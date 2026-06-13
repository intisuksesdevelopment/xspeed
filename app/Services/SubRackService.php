<?php

namespace App\Services;

use App\Constants\CommonConstants;
use App\Models\SubRack;
use Illuminate\Http\Request;
use App\Exceptions\AlreadyExistException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SubRackService
{
    public static function getPaginated(Request $request)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE);
        $sortBy = $request->input('sortBy', 'created_at');
        $sortDirection = $request->input('sortDirection', 'desc');

        // Optimized query - select only needed columns
        $query = SubRack::query()
            ->select('id', 'rack_id', 'name', 'code', 'description', 'image_url', 'status', 'created_at')
            ->with('rack:id,name,code');

        // Search functionality
        $search = $request->input('search', '');
        $searchBy = $request->input('search_by', 'name');

        if ($search) {
            if ($searchBy === 'code') {
                $query->where('code', 'like', '%' . $search . '%');
            } else {
                $query->where('name', 'like', '%' . $search . '%');
            }
        }

        // Filter by rack
        $rackId = $request->input('rack_id', '');
        if ($rackId) {
            $query->where('rack_id', $rackId);
        }

        $subracks = $query->orderBy($sortBy, $sortDirection)->paginate($perPage);
        foreach ($subracks as $subrack) {
            $subrack->availability = $subrack->isAvailable();
        }

        return $subracks;
    }

    public static function getActive(Request $request)
    {
        $sortBy = $request->input('sortBy', CommonConstants::SORT);
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION_DESC);

        // Optimized query - only load what's needed
        $subracks = SubRack::query()
            ->select('id', 'rack_id', 'name', 'code', 'status')
            ->where('status', 0)
            ->with('rack:id,name,code')
            ->orderBy($sortBy, $sortDirection)
            ->get();

        foreach ($subracks as $subrack) {
            $subrack->availability = $subrack->isAvailable();
        }

        return $subracks;
    }

    public static function getByRackId(Request $request, $rackId)
    {
        $sortBy = $request->input('sortBy', CommonConstants::SORT);
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION_DESC);

        $subracks = SubRack::where('rack_id', $rackId)->where('status', 0)->orderBy($sortBy, $sortDirection)->get();
        foreach ($subracks as $subrack) {
            $subrack->availability = $subrack->isAvailable();
        }

        return $subracks;
    }

    public static function save(Request $request)
    {
        try {
            $data = $request->all();
            $data['status'] = 0;

            $subrack = SubRack::whereRaw('LOWER(code) LIKE ?', ['%' . strtolower($data['code']) . '%'])->get();

            if ($subrack->isNotEmpty()) {
                $firstSubRack = $subrack->first();
                throw new AlreadyExistException("code : {$firstSubRack->code}");
            }

            $subrack = new SubRack;
            $subrack->validateAttributes($data);
            $subrack->fill($data);
            $subrack->save();

            return response()->json(['success' => true, 'message' => 'Add successfully!']);
        } catch (AlreadyExistException $e) {
            Log::error($e->getMessage());

            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'An error occurred. Please try again later.']);
        }
    }

    public static function update(Request $request)
    {
        try {
            $data = $request->all();
            $data['status'] = $data['status'] ?? 0;

            $subrack = SubRack::find($data['id']);
            if (!$subrack) {
                throw new NotFoundHttpException('code : ' . $data['code']);
            }
            $subrack->validateAttributes($data);
            $subrack->fill($data);
            $subrack->update();

            return response()->json([
                'success' => true,
                'message' => 'Update successfully!',
            ]);
        } catch (NotFoundHttpException $e) {
            Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'SubRack not found: ' . $e->getMessage(),
            ], 404);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred. Please try again later.',
            ], 500);
        }
    }

    public static function delete($id)
    {
        try {
            $subrack = SubRack::find($id);
            if (!$subrack) {
                throw new NotFoundHttpException('id : ' . $id);
            }
            $subrack->status = 1;
            $subrack->update();

            return response()->json([
                'success' => true,
                'message' => 'Removed successfully!',
            ]);
        } catch (NotFoundHttpException $e) {
            Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'SubRack not found: ' . $e->getMessage(),
            ], 404);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred. Please try again later.',
            ], 500);
        }
    }
}