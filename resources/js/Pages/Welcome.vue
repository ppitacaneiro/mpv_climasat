<script setup>
import { Head, Link } from "@inertiajs/vue3";

defineProps({
  canLogin: {
    type: Boolean,
  },
  canRegister: {
    type: Boolean,
  },
  laravelVersion: {
    type: String,
    required: true,
  },
  phpVersion: {
    type: String,
    required: true,
  },
});

function handleImageError() {
  document.getElementById("screenshot-container")?.classList.add("!hidden");
  document.getElementById("docs-card")?.classList.add("!row-span-1");
  document.getElementById("docs-card-content")?.classList.add("!flex-row");
  document.getElementById("background")?.classList.add("!hidden");
}
</script>

<template>
  <Head title="Welcome" />
  <div>
    <div
      class="relative flex min-h-screen flex-col items-center justify-center selection:text-white"
    >
      <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">

        <main class="font-sans text-gray-900">
          <!-- HEADER / HERO -->
          <header class="relative bg-gradient-to-r from-blue-600 to-blue-500 text-white">
          <nav v-if="canLogin" class="flex flex-1 justify-end">
            <Link
              v-if="$page.props.auth.user"
              :href="route('dashboard')"
              class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-black/70 focus:outline-none dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
            >
              Dashboard
            </Link>

            <template v-else>
              <Link
                :href="route('login')"
                class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-black/70 focus:outline-none dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
              >
                Log in
              </Link>

              <Link
                v-if="canRegister"
                :href="route('register')"
                class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-black/70 focus:outline-none dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
              >
                Register
              </Link>
            </template>
          </nav>
            <div
              class="container mx-auto px-6 py-20 flex flex-col md:flex-row items-center"
            >
              <div class="md:w-1/2 text-center md:text-left">
                <h1 class="text-5xl font-extrabold mb-6 leading-tight">
                  Gestiona avisos HVAC con ClimaSAT e IA
                </h1>
                <p class="mb-8 text-lg text-white/80">
                  ClimaSAT automatiza avisos, diagnósticos y partes de trabajo. Prioriza
                  incidencias, reduce errores y aumenta la eficiencia de tu SAT.
                </p>
                <div class="flex justify-center md:justify-start gap-4">
                  <a
                    href="#trial"
                    class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:scale-105 transition transform"
                    >Prueba gratis 14 días</a
                  >
                  <a
                    href="#demo"
                    class="border border-white text-white px-6 py-3 rounded-lg hover:bg-white hover:text-blue-600 transition"
                    >Ver demo</a
                  >
                </div>
              </div>
              <div class="md:w-1/2 mt-12 md:mt-0 flex justify-center">
                <img
                  src="https://via.placeholder.com/450x350"
                  alt="App Dashboard"
                  class="rounded-2xl shadow-2xl"
                />
              </div>
            </div>
          </header>

          <!-- SECCIÓN DE PROBLEMA -->
          <section class="container mx-auto px-6 py-20">
            <h2 class="text-4xl font-bold text-center mb-12">
              Los avisos HVAC consumen tiempo y generan errores
            </h2>
            <div class="grid md:grid-cols-4 gap-10 text-center">
              <div class="p-6 bg-white rounded-2xl shadow hover:shadow-lg transition">
                <img
                  src="https://via.placeholder.com/80"
                  class="mx-auto mb-4"
                  alt="Icono reloj"
                />
                <p class="text-gray-700">Avisos confusos de clientes</p>
              </div>
              <div class="p-6 bg-white rounded-2xl shadow hover:shadow-lg transition">
                <img
                  src="https://via.placeholder.com/80"
                  class="mx-auto mb-4"
                  alt="Icono error"
                />
                <p class="text-gray-700">Técnicos interpretan mensajes manualmente</p>
              </div>
              <div class="p-6 bg-white rounded-2xl shadow hover:shadow-lg transition">
                <img
                  src="https://via.placeholder.com/80"
                  class="mx-auto mb-4"
                  alt="Icono papeles"
                />
                <p class="text-gray-700">Partes de trabajo dispersos y desordenados</p>
              </div>
              <div class="p-6 bg-white rounded-2xl shadow hover:shadow-lg transition">
                <img
                  src="https://via.placeholder.com/80"
                  class="mx-auto mb-4"
                  alt="Icono coste"
                />
                <p class="text-gray-700">Diagnósticos lentos que aumentan costes</p>
              </div>
            </div>
          </section>

          <!-- SECCIÓN DE SOLUCIÓN -->
          <section class="py-20 gradient-bg text-white">
            <div class="container mx-auto px-6 text-center">
              <h2 class="text-4xl font-bold mb-16">
                ClimaSAT: soluciones inteligentes para tu SAT HVAC
              </h2>
              <div class="grid md:grid-cols-4 gap-12">
                <div
                  class="p-6 bg-white/10 rounded-2xl backdrop-blur-md hover:bg-white/20 transition"
                >
                  <img
                    src="https://via.placeholder.com/60"
                    class="mx-auto mb-4"
                    alt="IA icono"
                  />
                  <h3 class="font-semibold mb-2 text-lg">Clasificación automática</h3>
                  <p>La IA interpreta avisos y prioriza incidencias al instante.</p>
                </div>
                <div
                  class="p-6 bg-white/10 rounded-2xl backdrop-blur-md hover:bg-white/20 transition"
                >
                  <img
                    src="https://via.placeholder.com/60"
                    class="mx-auto mb-4"
                    alt="Solución icono"
                  />
                  <h3 class="font-semibold mb-2 text-lg">
                    Asignación inteligente de técnicos
                  </h3>
                  <p>Reduce errores y optimiza tiempos de intervención.</p>
                </div>
                <div
                  class="p-6 bg-white/10 rounded-2xl backdrop-blur-md hover:bg-white/20 transition"
                >
                  <img
                    src="https://via.placeholder.com/60"
                    class="mx-auto mb-4"
                    alt="App icono"
                  />
                  <h3 class="font-semibold mb-2 text-lg">Partes de trabajo digital</h3>
                  <p>Documenta fotos, notas y materiales desde la app móvil.</p>
                </div>
                <div
                  class="p-6 bg-white/10 rounded-2xl backdrop-blur-md hover:bg-white/20 transition"
                >
                  <img
                    src="https://via.placeholder.com/60"
                    class="mx-auto mb-4"
                    alt="KPIs icono"
                  />
                  <h3 class="font-semibold mb-2 text-lg">Historial y KPIs</h3>
                  <p>Visualiza el rendimiento de tu SAT y controla cada incidencia.</p>
                </div>
              </div>
            </div>
          </section>

          <!-- FLUJO / COMO FUNCIONA -->
          <section class="container mx-auto px-6 py-20">
            <h2 class="text-4xl font-bold text-center mb-16">
              Resuelve incidencias HVAC en 3 simples pasos
            </h2>
            <div class="flex flex-col md:flex-row justify-center items-center gap-12">
              <!-- Paso 1 -->
              <div class="text-center flex flex-col items-center">
                <div
                  class="w-24 h-24 bg-blue-100 text-blue-600 flex items-center justify-center rounded-full mb-4 font-bold text-xl"
                >
                  1
                </div>
                <h3 class="font-semibold mb-2">Cliente envía aviso</h3>
                <p class="text-gray-600 max-w-xs">Por web, WhatsApp o app móvil.</p>
                <div class="flow-line"></div>
              </div>
              <!-- Paso 2 -->
              <div class="text-center flex flex-col items-center">
                <div
                  class="w-24 h-24 bg-blue-100 text-blue-600 flex items-center justify-center rounded-full mb-4 font-bold text-xl"
                >
                  2
                </div>
                <h3 class="font-semibold mb-2">La IA clasifica y asigna</h3>
                <p class="text-gray-600 max-w-xs">
                  Detecta el problema y asigna el técnico ideal.
                </p>
                <div class="flow-line"></div>
              </div>
              <!-- Paso 3 -->
              <div class="text-center flex flex-col items-center">
                <div
                  class="w-24 h-24 bg-blue-100 text-blue-600 flex items-center justify-center rounded-full mb-4 font-bold text-xl"
                >
                  3
                </div>
                <h3 class="font-semibold mb-2">Técnico realiza intervención</h3>
                <p class="text-gray-600 max-w-xs">
                  Añade fotos, notas y cierra el ticket.
                </p>
              </div>
            </div>
          </section>

          <!-- PLANES -->
          <section class="bg-gray-50 py-20">
            <div class="container mx-auto px-6 text-center">
              <h2 class="text-4xl font-bold mb-16">
                Planes ClimaSAT diseñados para cada SAT HVAC
              </h2>
              <div class="grid md:grid-cols-3 gap-10">
                <!-- Starter -->
                <div
                  class="p-8 bg-white rounded-3xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-2"
                >
                  <h3 class="text-2xl font-semibold mb-4">Starter</h3>
                  <p class="text-gray-600 mb-4">15 €/mes - Autónomos / 1 técnico</p>
                  <ul class="text-gray-600 mb-6 space-y-2">
                    <li>20 avisos/mes</li>
                    <li>Acceso completo desde la app móvil</li>
                    <li>Historial completo de clientes y avisos</li>
                  </ul>
                  <a
                    href="#trial"
                    class="bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition"
                    >Prueba gratis</a
                  >
                </div>
                <!-- Basic -->
                <div
                  class="p-8 bg-white rounded-3xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-2"
                >
                  <h3 class="text-2xl font-semibold mb-4">Basic</h3>
                  <p class="text-gray-600 mb-4">29 €/mes - 1–3 técnicos</p>
                  <ul class="text-gray-600 mb-6 space-y-2">
                    <li>100 avisos/mes</li>
                    <li>IA que clasifica tipo de avería y urgencia</li>
                    <li>Firma digital y KPIs básicos</li>
                  </ul>
                  <a
                    href="#trial"
                    class="bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition"
                    >Prueba gratis</a
                  >
                </div>
                <!-- Pro -->
                <div
                  class="p-8 bg-white rounded-3xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-2"
                >
                  <h3 class="text-2xl font-semibold mb-4">Pro</h3>
                  <p class="text-gray-600 mb-4">49 €/mes - 3–10 técnicos</p>
                  <ul class="text-gray-600 mb-6 space-y-2">
                    <li>Avisos ilimitados</li>
                    <li>
                      IA avanzada: diagnóstico completo, asignación y rutas optimizadas
                    </li>
                    <li>Reporting avanzado</li>
                  </ul>
                  <a
                    href="#trial"
                    class="bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition"
                    >Prueba gratis</a
                  >
                </div>
              </div>
            </div>
          </section>

          <!-- CTA FINAL -->
          <section
            class="py-20 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-center"
          >
            <h2 class="text-4xl font-bold mb-6">
              Ahorra tiempo y gestiona tu SAT con ClimaSAT
            </h2>
            <p class="mb-8 text-lg">
              Crea tu primer ticket en menos de 3 minutos y comprueba la diferencia.
            </p>
            <a
              href="#trial"
              class="bg-white text-blue-600 px-8 py-4 rounded-xl font-semibold hover:scale-105 transition transform"
              >Prueba gratis 14 días</a
            >
          </section>
        </main>

        <footer class="py-16 text-center text-sm text-black dark:text-white/70">
          ClimaSAT &copy; 2026. Todos los derechos reservados.
        </footer>
      </div>
    </div>
  </div>
</template>
<style scoped>
.gradient-bg {
  background: linear-gradient(90deg, #3b82f6, #2563eb);
}
.flow-line::after {
  content: "";
  display: block;
  width: 2px;
  height: 40px;
  background: #3b82f6;
  margin: 0 auto;
}
</style>
