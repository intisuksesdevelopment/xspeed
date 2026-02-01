<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
</head>
<style>
    .shimmer-item {
        height: 70px;
        margin-bottom: 12px;
        border-radius: 8px;
        background: linear-gradient(90deg, #eee 25%, #ddd 37%, #eee 63%);
        background-size: 400% 100%;
        animation: shimmer 1.4s ease infinite;
    }

    @keyframes shimmer {
        0% {
            background-position: 100% 0;
        }

        100% {
            background-position: -100% 0;
        }
    }

    .hidden {
        display: none;
    }
</style>

<body>asd
    <div id="warehouse-section">
        <div class="shimmer-wrapper"></div>
        <div class="content-wrapper hidden"></div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            /* 1️⃣ SELECT / DROPDOWN */
            loadAsyncSection({
                url: "{{ route('api-warehouse-active') }}",
                containerId: 'warehouse-section',
                wrapper: (content) => `
            <select id="filter-warehouse">
                <option value="">Choose Warehouse</option>
                ${content}
            </select>
        `,
                renderItem: (item) => `
            <option value="${item.code}">
                ${item.name}
            </option>
        `
            });
        });

        async function loadAsyncSection({
            url,
            containerId,
            renderItem,
            wrapper = (content) => content,
            method = 'GET',
            body = null,
            shimmerCount = 3,
            emptyText = 'Tidak ada data'
        }) {
            const container = document.getElementById(containerId);
            if (!container) return;

            const shimmerWrapper = container.querySelector('.shimmer-wrapper');
            const contentWrapper = container.querySelector('.content-wrapper');

            // loading state
            shimmerWrapper.innerHTML = '';
            shimmerWrapper.classList.remove('hidden');
            contentWrapper.classList.add('hidden');

            for (let i = 0; i < shimmerCount; i++) {
                shimmerWrapper.innerHTML += `<div class="shimmer-item"></div>`;
            }

            try {
                const response = await fetch(url, {
                    method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: body ? JSON.stringify(body) : null
                });

                const result = await response.json();
                let items = result.data ?? result;
                if (!Array.isArray(items)) items = [items];

                shimmerWrapper.classList.add('hidden');
                contentWrapper.classList.remove('hidden');

                if (items.length === 0) {
                    contentWrapper.innerHTML = `<p>${emptyText}</p>`;
                    return;
                }

                const html = items.map(renderItem).join('');
                contentWrapper.innerHTML = wrapper(html);

            } catch (err) {
                shimmerWrapper.innerHTML = `<p>Gagal memuat data</p>`;
                console.error(err);
            }
        }
    </script>
</body>

</html>
