self.addEventListener('fetch', function (event) {
    const cachables = ['/vendor', '/assets'];

    if (!cachables.some((cachable) => event.request.url.includes(cachable))) {
        return;
    }

    event.respondWith(
        caches.open('v1').then(async (cache) => {
            let response = await cache.match(event.request);

            // If the response is in the cache, return it
            if (response) return response;

            // Otherwise, fetch the response from the network and cache it
            response = await fetch(event.request);
            cache.put(event.request, response.clone());

            return response;
        }),
    );
});
