var cacheName = 'v2';
var cacheFiles = [
	'/',
	'index.html',
	'css/bootstrap.min.css',
	'css/style.css',
	'css/animate.css',
	'js/app.js'
]

self.addEventListener('install', function(e){
	console.log("[ServiceWorker] Installed");

	e.waitUntil(
		caches.open(cacheName).then(function(cache){
			console.log("[ServiceWorker] Caching cacheFiles");
			return cache.addAll(cacheFiles);
		})
	)
})

self.addEventListener('activate',function(e){
	console.log("[ServiceWorker] Activated");

	e.waitUntil(
		caches.keys().then(function(cacheNames){
			return Promise.all(cacheNames.map(function(thisCacheName){
				if (thisCacheName !== cacheName) {
					console.log("[ServiceWorker] Removing Cached Files from", thisCacheName);
					return caches.delete(thisCacheName);
				}
			}))
		})
	)
})

self.addEventListener('fetch', function(e){
	console.log("[ServiceWorker] Fetching", e.request.url);

	e.respondWith(
		caches.match(e.request).then(function(response){
			if ( response ) {
				console.log("[ServiceWorker] found in cache", e.request.url);
				return response;
			}

			var requestClone = e.request.clone();

			fetch(requestClone).then(function(response){
				if (!response) {
					console.log("[ServiceWorker] No response from fetch");
					return response;
				}

				var responseClone = response.clone();

				caches.open(cacheName).then(function(cache){
					cache.put(e.request, responseClone);
					return response;
				});
			})
			.catch(function(err){
				console.log("[ServiceWorker] Error Fetching & Caching New Data");
			})
		})
	)
})