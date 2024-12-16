
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Liked Canteens</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
      rel="stylesheet"
    />
  </head>
  <body class="bg-white min-h-screen">
    <div class="container mx-auto px-4 py-8">
      <div
        class="max-w-4xl mx-auto bg-white shadow-2xl rounded-2xl overflow-hidden"
      >
        <div class="bg-green-600 text-white py-6 px-6 text-center">
          <h1 class="text-3xl font-bold flex items-center justify-center">
            <i class="fas fa-heart text-white mr-4"></i>
            Your Favorites at UnandEats
          </h1>
        </div>

        <div class="p-6">
          <div
            id="kantinList"
            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
          >
            <!-- Example Kantin Box 1 -->
            <div
              class="bg-white border border-green-100 rounded-lg shadow-md overflow-hidden transform hover:scale-105 transition duration-300 ease-in-out"
            >
              <div class="relative">
                <img src="" alt="" class="w-full h-48 object-cover" />
                <div class="absolute top-4 right-4">
                  <button
                    class="bg-red-50 text-red-500 w-8 h-8 flex items-center justify-center rounded-full border border-red-200 hover:bg-red-100 hover:text-red-600 transition duration-300 ease-in-out"
                  >
                    <i class="fas fa-x"></i>
                  </button>
                </div>
              </div>
              <div class="p-4">
                <h2 class="text-xl font-bold text-green-700 mb-2">
                  Kantin Bunda
                </h2>
                <p class="text-gray-600 mb-4">
                  Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo,
                  excepturi.
                </p>
                <div class="flex justify-between items-center">
                  <span class="text-green-600 font-semibold">
                    <i class="fas fa-star mr-1"></i> 4.5
                  </span>
                  <a
                    href="#"
                    class="px-4 py-2 bg-green-500 text-white rounded-lg shadow-md hover:bg-blue-600 transition duration-300 ease-in-out"
                  >
                    Details
                  </a>
                </div>
              </div>
            </div>

            <!-- Example Kantin Box 2 -->
            <div
              class="bg-white border border-green-100 rounded-lg shadow-md overflow-hidden transform hover:scale-105 transition duration-300 ease-in-out"
            >
              <div class="relative">
                <img src="" alt="" class="w-full h-48 object-cover" />
                <div class="absolute top-4 right-4">
                  <button
                    class="bg-red-50 text-red-500 w-8 h-8 flex items-center justify-center rounded-full border border-red-200 hover:bg-red-100 hover:text-red-600 transition duration-300 ease-in-out"
                  >
                    <i class="fas fa-x"></i>
                  </button>
                </div>
              </div>
              <div class="p-4">
                <h2 class="text-xl font-bold text-green-700 mb-2">
                  Kantin Nice
                </h2>
                <p class="text-gray-600 mb-4">
                  Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                  Repellendus, tempore?
                </p>
                <div class="flex justify-between items-center">
                  <span class="text-green-600 font-semibold">
                    <i class="fas fa-star mr-1"></i> 4.7
                  </span>
                  <a
                    href="#"
                    class="px-4 py-2 bg-green-500 text-white rounded-lg shadow-md hover:bg-blue-600 transition duration-300 ease-in-out"
                  >
                    Details
                  </a>
                </div>
              </div>
            </div>

            <!-- Example Kantin Box 3 -->
            <div
              class="bg-white border border-green-100 rounded-lg shadow-md overflow-hidden transform hover:scale-105 transition duration-300 ease-in-out"
            >
              <div class="relative">
                <img src="" alt="" class="w-full h-48 object-cover" />
                <div class="absolute top-4 right-4">
                  <button
                    class="bg-red-50 text-red-500 w-8 h-8 flex items-center justify-center rounded-full border border-red-200 hover:bg-red-100 hover:text-red-600 transition duration-300 ease-in-out"
                  >
                    <i class="fas fa-x"></i>
                  </button>
                </div>
              </div>
              <div class="p-4">
                <h2 class="text-xl font-bold text-green-700 mb-2">
                  Kantin Mamsky
                </h2>
                <p class="text-gray-600 mb-4">
                  Lorem ipsum dolor sit amet consectetur adipisicing elit.
                  Alias, deleniti.
                </p>
                <div class="flex justify-between items-center">
                  <span class="text-green-600 font-semibold">
                    <i class="fas fa-star mr-1"></i> 4.3
                  </span>
                  <a
                  href="#"
                  class="px-4 py-2 bg-green-500 text-white rounded-lg shadow-md hover:bg-blue-600 transition duration-300 ease-in-out"
                >
                  Details
                </a>
                </div>
              </div>
            </div>
          </div>

          <!-- Empty State -->
          <div id="emptyState" class="hidden text-center py-10">
            <i class="fas fa-utensils text-green-400 text-6xl mb-4"></i>
            <p class="text-xl text-gray-600">Belum ada kantin favorit</p>
            <p class="text-gray-500">Jelajahi dan tandai kantin favorit Anda</p>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
