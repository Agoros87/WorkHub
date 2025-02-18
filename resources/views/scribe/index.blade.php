<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>WorkHub Documentation</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.style.css") }}" media="screen">
    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.print.css") }}" media="print">

    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>

    <link rel="stylesheet"
          href="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/styles/obsidian.min.css">
    <script src="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/highlight.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jets/0.14.1/jets.min.js"></script>

    <style id="language-style">
        /* starts out as display none and is replaced with js later  */
                    body .content .bash-example code { display: none; }
                    body .content .javascript-example code { display: none; }
            </style>

    <script>
        var tryItOutBaseUrl = "http://workhub.test";
        var useCsrf = Boolean();
        var csrfUrl = "/sanctum/csrf-cookie";
    </script>
    <script src="{{ asset("/vendor/scribe/js/tryitout-4.40.0.js") }}"></script>

    <script src="{{ asset("/vendor/scribe/js/theme-default-4.40.0.js") }}"></script>

</head>

<body data-languages="[&quot;bash&quot;,&quot;javascript&quot;]">

<a href="#" id="nav-button">
    <span>
        MENU
        <img src="{{ asset("/vendor/scribe/images/navbar.png") }}" alt="navbar-image"/>
    </span>
</a>
<div class="tocify-wrapper">
    
            <div class="lang-selector">
                                            <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                            <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                    </div>
    
    <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>

    <div id="toc">
                    <ul id="tocify-header-introduction" class="tocify-header">
                <li class="tocify-item level-1" data-unique="introduction">
                    <a href="#introduction">Introduction</a>
                </li>
                            </ul>
                    <ul id="tocify-header-authenticating-requests" class="tocify-header">
                <li class="tocify-item level-1" data-unique="authenticating-requests">
                    <a href="#authenticating-requests">Authenticating requests</a>
                </li>
                            </ul>
                    <ul id="tocify-header-advertisement-management" class="tocify-header">
                <li class="tocify-item level-1" data-unique="advertisement-management">
                    <a href="#advertisement-management">Advertisement Management</a>
                </li>
                                    <ul id="tocify-subheader-advertisement-management" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="advertisement-management-GETapi-advertisements">
                                <a href="#advertisement-management-GETapi-advertisements">Listar Anuncios</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="advertisement-management-GETapi-advertisements--advertisement_slug-">
                                <a href="#advertisement-management-GETapi-advertisements--advertisement_slug-">Ver Anuncio</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="advertisement-management-POSTapi-advertisements">
                                <a href="#advertisement-management-POSTapi-advertisements">Crear Anuncio</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="advertisement-management-PUTapi-advertisements--slug-">
                                <a href="#advertisement-management-PUTapi-advertisements--slug-">Actualizar Anuncio</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="advertisement-management-DELETEapi-advertisements--slug-">
                                <a href="#advertisement-management-DELETEapi-advertisements--slug-">Eliminar Anuncio</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-autenticacion" class="tocify-header">
                <li class="tocify-item level-1" data-unique="autenticacion">
                    <a href="#autenticacion">Autenticación</a>
                </li>
                                    <ul id="tocify-subheader-autenticacion" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="autenticacion-POSTapi-login">
                                <a href="#autenticacion-POSTapi-login">Login</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="autenticacion-POSTapi-logout">
                                <a href="#autenticacion-POSTapi-logout">Logout</a>
                            </li>
                                                                        </ul>
                            </ul>
            </div>

    <ul class="toc-footer" id="toc-footer">
                    <li style="padding-bottom: 5px;"><a href="{{ route("scribe.postman") }}">View Postman collection</a></li>
                            <li style="padding-bottom: 5px;"><a href="{{ route("scribe.openapi") }}">View OpenAPI spec</a></li>
                <li><a href="http://github.com/knuckleswtf/scribe">Documentation powered by Scribe ✍</a></li>
    </ul>

    <ul class="toc-footer" id="last-updated">
        <li>Last updated: February 18, 2025</li>
    </ul>
</div>

<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1 id="introduction">Introduction</h1>
<aside>
    <strong>Base URL</strong>: <code>http://workhub.test</code>
</aside>
<p>This documentation aims to provide all the information you need to work with our API.</p>
<aside>As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile).
You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).</aside>

        <h1 id="authenticating-requests">Authenticating requests</h1>
<p>To authenticate requests, include an <strong><code>Authorization</code></strong> header with the value <strong><code>"Bearer {YOUR_AUTH_KEY}"</code></strong>.</p>
<p>All authenticated endpoints are marked with a <code>requires authentication</code> badge in the documentation below.</p>
<p>You can retrieve your token by visiting your dashboard and clicking <b>Generate API token</b>.</p>

        <h1 id="advertisement-management">Advertisement Management</h1>

    <p>APIs para gestionar anuncios de trabajo</p>

                                <h2 id="advertisement-management-GETapi-advertisements">Listar Anuncios</h2>

<p>
</p>

<p>Obtiene una lista paginada de anuncios que puede ser filtrada por varios criterios.</p>

<span id="example-requests-GETapi-advertisements">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://workhub.test/api/advertisements?type=worker&amp;location=Madrid&amp;skills[]=Camarero+de+barra&amp;skills[]=Camarero+de+sala&amp;keyword=Barista" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://workhub.test/api/advertisements"
);

const params = {
    "type": "worker",
    "location": "Madrid",
    "skills[0]": "Camarero de barra",
    "skills[1]": "Camarero de sala",
    "keyword": "Barista",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-advertisements">
            <blockquote>
            <p>Example response (200, success):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: [
        {
            &quot;id&quot;: 1,
            &quot;type&quot;: &quot;employer&quot;,
            &quot;title&quot;: &quot;Se busca camarero de barra&quot;,
            &quot;description&quot;: &quot;Buscamos camarero de barra con experiencia en cocteler&iacute;a&quot;,
            &quot;slug&quot;: &quot;se-busca-camarero-de-barra&quot;,
            &quot;skills&quot;: [
                &quot;Camarero de barra&quot;,
                &quot;Camarero de sala&quot;
            ],
            &quot;experience&quot;: &quot;3-5 a&ntilde;os&quot;,
            &quot;schedule&quot;: &quot;Tiempo completo&quot;,
            &quot;contract_type&quot;: &quot;Indefinido&quot;,
            &quot;salary&quot;: 35000,
            &quot;availability&quot;: &quot;Inmediata&quot;,
            &quot;salary_expectation&quot;: null,
            &quot;location&quot;: &quot;Madrid&quot;,
            &quot;user_id&quot;: 1,
            &quot;user&quot;: {
                &quot;id&quot;: 1,
                &quot;name&quot;: &quot;Pepito S.L.&quot;,
                &quot;email&quot;: &quot;rrhh@empresa.com&quot;
            },
            &quot;created_at&quot;: &quot;2025-02-17T23:26:05.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2025-02-17T23:26:05.000000Z&quot;
        }
    ],
    &quot;links&quot;: {
        &quot;first&quot;: &quot;http://workhub.test/api/advertisements?page=1&quot;,
        &quot;last&quot;: &quot;http://workhub.test/api/advertisements?page=1&quot;,
        &quot;prev&quot;: null,
        &quot;next&quot;: null
    },
    &quot;meta&quot;: {
        &quot;current_page&quot;: 1,
        &quot;from&quot;: 1,
        &quot;last_page&quot;: 1,
        &quot;path&quot;: &quot;http://workhub.test/api/advertisements&quot;,
        &quot;per_page&quot;: 10,
        &quot;to&quot;: 1,
        &quot;total&quot;: 1
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-advertisements" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-advertisements"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-advertisements"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-advertisements" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-advertisements">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-advertisements" data-method="GET"
      data-path="api/advertisements"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-advertisements', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-advertisements"
                    onclick="tryItOut('GETapi-advertisements');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-advertisements"
                    onclick="cancelTryOut('GETapi-advertisements');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-advertisements"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/advertisements</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-advertisements"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-advertisements"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="type"                data-endpoint="GETapi-advertisements"
               value="worker"
               data-component="query">
    <br>
<p>Filtrar por tipo de anuncio (employer/worker). Example: <code>worker</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>location</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="location"                data-endpoint="GETapi-advertisements"
               value="Madrid"
               data-component="query">
    <br>
<p>Filtrar por ubicación. Example: <code>Madrid</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>skills</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="skills[0]"                data-endpoint="GETapi-advertisements"
               data-component="query">
        <input type="text" style="display: none"
               name="skills[1]"                data-endpoint="GETapi-advertisements"
               data-component="query">
    <br>
<p>Filtrar por habilidades requeridas.</p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>keyword</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="keyword"                data-endpoint="GETapi-advertisements"
               value="Barista"
               data-component="query">
    <br>
<p>Buscar por palabra clave en título o descripción. Example: <code>Barista</code></p>
            </div>
                </form>

                    <h2 id="advertisement-management-GETapi-advertisements--advertisement_slug-">Ver Anuncio</h2>

<p>
</p>

<p>Obtiene los detalles de un anuncio específico.</p>

<span id="example-requests-GETapi-advertisements--advertisement_slug-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://workhub.test/api/advertisements/disponible-como-barman-coctelero-k5azb1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://workhub.test/api/advertisements/disponible-como-barman-coctelero-k5azb1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-advertisements--advertisement_slug-">
            <blockquote>
            <p>Example response (200, success):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: {
        &quot;id&quot;: 1,
        &quot;type&quot;: &quot;employer&quot;,
        &quot;title&quot;: &quot;Se busca camarero de sala&quot;,
        &quot;description&quot;: &quot;Buscamos camarero de sala con experiencia en servicio de mesas&quot;,
        &quot;slug&quot;: &quot;se-busca-camarero-de-sala&quot;,
        &quot;skills&quot;: [
            &quot;Camarero de sala&quot;,
            &quot;Servicio de mesas&quot;
        ],
        &quot;experience&quot;: &quot;3-5 a&ntilde;os&quot;,
        &quot;schedule&quot;: &quot;Tiempo completo&quot;,
        &quot;contract_type&quot;: &quot;Indefinido&quot;,
        &quot;salary&quot;: 35000,
        &quot;availability&quot;: &quot;Inmediata&quot;,
        &quot;salary_expectation&quot;: null,
        &quot;location&quot;: &quot;Madrid&quot;,
        &quot;user_id&quot;: 1,
        &quot;user&quot;: {
            &quot;id&quot;: 1,
            &quot;name&quot;: &quot;Empresa Tech&quot;,
            &quot;email&quot;: &quot;rrhh@empresa.com&quot;
        },
        &quot;created_at&quot;: &quot;2025-02-17T23:26:05.000000Z&quot;,
        &quot;updated_at&quot;: &quot;2025-02-17T23:26:05.000000Z&quot;
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (404, not found):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;No se encontr&oacute; el anuncio&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-advertisements--advertisement_slug-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-advertisements--advertisement_slug-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-advertisements--advertisement_slug-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-advertisements--advertisement_slug-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-advertisements--advertisement_slug-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-advertisements--advertisement_slug-" data-method="GET"
      data-path="api/advertisements/{advertisement_slug}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-advertisements--advertisement_slug-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-advertisements--advertisement_slug-"
                    onclick="tryItOut('GETapi-advertisements--advertisement_slug-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-advertisements--advertisement_slug-"
                    onclick="cancelTryOut('GETapi-advertisements--advertisement_slug-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-advertisements--advertisement_slug-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/advertisements/{advertisement_slug}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-advertisements--advertisement_slug-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-advertisements--advertisement_slug-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>advertisement_slug</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="advertisement_slug"                data-endpoint="GETapi-advertisements--advertisement_slug-"
               value="disponible-como-barman-coctelero-k5azb1"
               data-component="url">
    <br>
<p>The slug of the advertisement. Example: <code>disponible-como-barman-coctelero-k5azb1</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>advertisement</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="advertisement"                data-endpoint="GETapi-advertisements--advertisement_slug-"
               value="1"
               data-component="url">
    <br>
<p>El ID del anuncio. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="advertisement-management-POSTapi-advertisements">Crear Anuncio</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Crea un nuevo anuncio de trabajo.</p>

<span id="example-requests-POSTapi-advertisements">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://workhub.test/api/advertisements" \
    --header "Authorization: Bearer {YOUR_AUTH_KEY}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"title\": \"Camarero de barra con experiencia en coctelería\",
    \"description\": \"Buscamos camarero de barra con experiencia en coctelería\",
    \"location\": \"Madrid\",
    \"skills\": [
        \"Camarero de barra\",
        \"Camarero de sala\"
    ],
    \"experience\": \"3-5 años\",
    \"schedule\": \"Tiempo completo\",
    \"contract_type\": \"Indefinido\",
    \"availability\": \"Inmediata\",
    \"salary\": \"35000\",
    \"salary_expectation\": \"40000\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://workhub.test/api/advertisements"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "title": "Camarero de barra con experiencia en coctelería",
    "description": "Buscamos camarero de barra con experiencia en coctelería",
    "location": "Madrid",
    "skills": [
        "Camarero de barra",
        "Camarero de sala"
    ],
    "experience": "3-5 años",
    "schedule": "Tiempo completo",
    "contract_type": "Indefinido",
    "availability": "Inmediata",
    "salary": "35000",
    "salary_expectation": "40000"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-advertisements">
            <blockquote>
            <p>Example response (201, success):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: {
        &quot;id&quot;: 1,
        &quot;type&quot;: &quot;employer&quot;,
        &quot;title&quot;: &quot;Se busca camarero de barra con experiencia en cocteler&iacute;a&quot;,
        &quot;description&quot;: &quot;Buscamos camarero de barra con experiencia en cocteler&iacute;a. Se valorar&aacute; experiencia en cocteler&iacute;a&quot;,
        &quot;slug&quot;: &quot;se-busca-camarero-de-barra-con-experiencia-en-cocteleria&quot;,
        &quot;skills&quot;: [
            &quot;Camarero de barra&quot;,
            &quot;Camarero de sala&quot;
        ],
        &quot;experience&quot;: &quot;3-5 a&ntilde;os&quot;,
        &quot;schedule&quot;: &quot;Tiempo completo&quot;,
        &quot;contract_type&quot;: &quot;Indefinido&quot;,
        &quot;salary&quot;: 35000,
        &quot;availability&quot;: &quot;Inmediata&quot;,
        &quot;salary_expectation&quot;: null,
        &quot;location&quot;: &quot;Madrid&quot;,
        &quot;user_id&quot;: 1,
        &quot;user&quot;: {
            &quot;id&quot;: 1,
            &quot;name&quot;: &quot;Empresa Tech&quot;,
            &quot;email&quot;: &quot;rrhh@empresa.com&quot;
        },
        &quot;created_at&quot;: &quot;2025-02-17T23:26:05.000000Z&quot;,
        &quot;updated_at&quot;: &quot;2025-02-17T23:26:05.000000Z&quot;
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (422, validation error):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Los datos proporcionados no son v&aacute;lidos.&quot;,
    &quot;errors&quot;: {
        &quot;title&quot;: [
            &quot;El t&iacute;tulo es obligatorio&quot;
        ],
        &quot;skills&quot;: [
            &quot;Las habilidades son obligatorias&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-advertisements" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-advertisements"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-advertisements"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-advertisements" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-advertisements">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-advertisements" data-method="POST"
      data-path="api/advertisements"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-advertisements', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-advertisements"
                    onclick="tryItOut('POSTapi-advertisements');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-advertisements"
                    onclick="cancelTryOut('POSTapi-advertisements');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-advertisements"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/advertisements</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-advertisements"
               value="Bearer {YOUR_AUTH_KEY}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_KEY}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-advertisements"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-advertisements"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>title</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="title"                data-endpoint="POSTapi-advertisements"
               value="Camarero de barra con experiencia en coctelería"
               data-component="body">
    <br>
<p>Título del anuncio. Example: <code>Camarero de barra con experiencia en coctelería</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>description</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="description"                data-endpoint="POSTapi-advertisements"
               value="Buscamos camarero de barra con experiencia en coctelería"
               data-component="body">
    <br>
<p>Descripción detallada del anuncio. Example: <code>Buscamos camarero de barra con experiencia en coctelería</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>location</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="location"                data-endpoint="POSTapi-advertisements"
               value="Madrid"
               data-component="body">
    <br>
<p>Ubicación del trabajo. Example: <code>Madrid</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>skills</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="skills[0]"                data-endpoint="POSTapi-advertisements"
               data-component="body">
        <input type="text" style="display: none"
               name="skills[1]"                data-endpoint="POSTapi-advertisements"
               data-component="body">
    <br>
<p>Lista de habilidades requeridas.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>experience</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="experience"                data-endpoint="POSTapi-advertisements"
               value="3-5 años"
               data-component="body">
    <br>
<p>Experiencia requerida. Example: <code>3-5 años</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>schedule</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="schedule"                data-endpoint="POSTapi-advertisements"
               value="Tiempo completo"
               data-component="body">
    <br>
<p>Horario de trabajo. Example: <code>Tiempo completo</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>contract_type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="contract_type"                data-endpoint="POSTapi-advertisements"
               value="Indefinido"
               data-component="body">
    <br>
<p>Tipo de contrato. Example: <code>Indefinido</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>availability</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="availability"                data-endpoint="POSTapi-advertisements"
               value="Inmediata"
               data-component="body">
    <br>
<p>Disponibilidad. Example: <code>Inmediata</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>salary</code></b>&nbsp;&nbsp;
<small>numeric</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="salary"                data-endpoint="POSTapi-advertisements"
               value="35000"
               data-component="body">
    <br>
<p>Salario ofrecido (para empresas). Example: <code>35000</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>salary_expectation</code></b>&nbsp;&nbsp;
<small>numeric</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="salary_expectation"                data-endpoint="POSTapi-advertisements"
               value="40000"
               data-component="body">
    <br>
<p>Expectativa salarial (para candidatos). Example: <code>40000</code></p>
        </div>
        </form>

                    <h2 id="advertisement-management-PUTapi-advertisements--slug-">Actualizar Anuncio</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Actualiza un anuncio existente.</p>

<span id="example-requests-PUTapi-advertisements--slug-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://workhub.test/api/advertisements/disponible-como-barman-coctelero-k5azb1" \
    --header "Authorization: Bearer {YOUR_AUTH_KEY}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"title\": \"Camarero de barra con experiencia en coctelería\",
    \"description\": \"Se ofrece camarero de barra con experiencia en coctelería\",
    \"location\": \"Madrid\",
    \"skills\": [
        \"Camarero de barra\",
        \"Camarero de sala\"
    ],
    \"experience\": \"5+ años\",
    \"schedule\": \"Tiempo completo\",
    \"contract_type\": \"Indefinido\",
    \"availability\": \"Inmediata\",
    \"salary\": \"40000\",
    \"salary_expectation\": \"45000\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://workhub.test/api/advertisements/disponible-como-barman-coctelero-k5azb1"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "title": "Camarero de barra con experiencia en coctelería",
    "description": "Se ofrece camarero de barra con experiencia en coctelería",
    "location": "Madrid",
    "skills": [
        "Camarero de barra",
        "Camarero de sala"
    ],
    "experience": "5+ años",
    "schedule": "Tiempo completo",
    "contract_type": "Indefinido",
    "availability": "Inmediata",
    "salary": "40000",
    "salary_expectation": "45000"
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-advertisements--slug-">
            <blockquote>
            <p>Example response (200, success):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: {
        &quot;id&quot;: 1,
        &quot;type&quot;: &quot;employer&quot;,
        &quot;title&quot;: &quot;Se busca camarero de barra&quot;,
        &quot;description&quot;: &quot;Se busca camarero de barra con experiencia en cocteler&iacute;a&quot;,
        &quot;slug&quot;: &quot;se-busca-camarero-de-barra&quot;,
        &quot;skills&quot;: [
            &quot;Camarero de barra&quot;,
            &quot;Camarero de sala&quot;
        ],
        &quot;experience&quot;: &quot;5+ a&ntilde;os&quot;,
        &quot;schedule&quot;: &quot;Tiempo completo&quot;,
        &quot;contract_type&quot;: &quot;Indefinido&quot;,
        &quot;salary&quot;: 40000,
        &quot;availability&quot;: &quot;Inmediata&quot;,
        &quot;salary_expectation&quot;: null,
        &quot;location&quot;: &quot;Madrid&quot;,
        &quot;user_id&quot;: 1,
        &quot;user&quot;: {
            &quot;id&quot;: 1,
            &quot;name&quot;: &quot;Empresa Tech&quot;,
            &quot;email&quot;: &quot;rrhh@empresa.com&quot;
        },
        &quot;created_at&quot;: &quot;2025-02-17T23:26:05.000000Z&quot;,
        &quot;updated_at&quot;: &quot;2025-02-17T23:26:05.000000Z&quot;
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (403, unauthorized):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;No est&aacute; autorizado para actualizar este anuncio&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404, not found):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;No se encontr&oacute; el anuncio&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-PUTapi-advertisements--slug-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-advertisements--slug-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-advertisements--slug-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-advertisements--slug-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-advertisements--slug-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-advertisements--slug-" data-method="PUT"
      data-path="api/advertisements/{slug}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-advertisements--slug-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-advertisements--slug-"
                    onclick="tryItOut('PUTapi-advertisements--slug-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-advertisements--slug-"
                    onclick="cancelTryOut('PUTapi-advertisements--slug-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-advertisements--slug-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/advertisements/{slug}</code></b>
        </p>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/advertisements/{slug}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="PUTapi-advertisements--slug-"
               value="Bearer {YOUR_AUTH_KEY}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_KEY}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-advertisements--slug-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-advertisements--slug-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>slug</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="slug"                data-endpoint="PUTapi-advertisements--slug-"
               value="disponible-como-barman-coctelero-k5azb1"
               data-component="url">
    <br>
<p>The slug of the advertisement. Example: <code>disponible-como-barman-coctelero-k5azb1</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>advertisement</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="advertisement"                data-endpoint="PUTapi-advertisements--slug-"
               value="1"
               data-component="url">
    <br>
<p>El ID del anuncio. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>title</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="title"                data-endpoint="PUTapi-advertisements--slug-"
               value="Camarero de barra con experiencia en coctelería"
               data-component="body">
    <br>
<p>Título del anuncio. Example: <code>Camarero de barra con experiencia en coctelería</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>description</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="description"                data-endpoint="PUTapi-advertisements--slug-"
               value="Se ofrece camarero de barra con experiencia en coctelería"
               data-component="body">
    <br>
<p>Descripción detallada del anuncio. Example: <code>Se ofrece camarero de barra con experiencia en coctelería</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>location</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="location"                data-endpoint="PUTapi-advertisements--slug-"
               value="Madrid"
               data-component="body">
    <br>
<p>Ubicación del trabajo. Example: <code>Madrid</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>skills</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="skills[0]"                data-endpoint="PUTapi-advertisements--slug-"
               data-component="body">
        <input type="text" style="display: none"
               name="skills[1]"                data-endpoint="PUTapi-advertisements--slug-"
               data-component="body">
    <br>
<p>Lista de habilidades requeridas.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>experience</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="experience"                data-endpoint="PUTapi-advertisements--slug-"
               value="5+ años"
               data-component="body">
    <br>
<p>Experiencia requerida. Example: <code>5+ años</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>schedule</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="schedule"                data-endpoint="PUTapi-advertisements--slug-"
               value="Tiempo completo"
               data-component="body">
    <br>
<p>Horario de trabajo. Example: <code>Tiempo completo</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>contract_type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="contract_type"                data-endpoint="PUTapi-advertisements--slug-"
               value="Indefinido"
               data-component="body">
    <br>
<p>Tipo de contrato. Example: <code>Indefinido</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>availability</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="availability"                data-endpoint="PUTapi-advertisements--slug-"
               value="Inmediata"
               data-component="body">
    <br>
<p>Disponibilidad. Example: <code>Inmediata</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>salary</code></b>&nbsp;&nbsp;
<small>numeric</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="salary"                data-endpoint="PUTapi-advertisements--slug-"
               value="40000"
               data-component="body">
    <br>
<p>Salario ofrecido (para empresas). Example: <code>40000</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>salary_expectation</code></b>&nbsp;&nbsp;
<small>numeric</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="salary_expectation"                data-endpoint="PUTapi-advertisements--slug-"
               value="45000"
               data-component="body">
    <br>
<p>Expectativa salarial (para candidatos). Example: <code>45000</code></p>
        </div>
        </form>

                    <h2 id="advertisement-management-DELETEapi-advertisements--slug-">Eliminar Anuncio</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Elimina un anuncio existente.</p>

<span id="example-requests-DELETEapi-advertisements--slug-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://workhub.test/api/advertisements/disponible-como-barman-coctelero-k5azb1" \
    --header "Authorization: Bearer {YOUR_AUTH_KEY}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://workhub.test/api/advertisements/disponible-como-barman-coctelero-k5azb1"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-advertisements--slug-">
            <blockquote>
            <p>Example response (200, success):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Anuncio eliminado correctamente&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (403, unauthorized):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;No est&aacute; autorizado para eliminar este anuncio&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404, not found):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;No se encontr&oacute; el anuncio&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-DELETEapi-advertisements--slug-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-advertisements--slug-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-advertisements--slug-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-advertisements--slug-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-advertisements--slug-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-advertisements--slug-" data-method="DELETE"
      data-path="api/advertisements/{slug}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-advertisements--slug-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-advertisements--slug-"
                    onclick="tryItOut('DELETEapi-advertisements--slug-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-advertisements--slug-"
                    onclick="cancelTryOut('DELETEapi-advertisements--slug-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-advertisements--slug-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/advertisements/{slug}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="DELETEapi-advertisements--slug-"
               value="Bearer {YOUR_AUTH_KEY}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_KEY}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-advertisements--slug-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-advertisements--slug-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>slug</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="slug"                data-endpoint="DELETEapi-advertisements--slug-"
               value="disponible-como-barman-coctelero-k5azb1"
               data-component="url">
    <br>
<p>The slug of the advertisement. Example: <code>disponible-como-barman-coctelero-k5azb1</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>advertisement</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="advertisement"                data-endpoint="DELETEapi-advertisements--slug-"
               value="1"
               data-component="url">
    <br>
<p>El ID del anuncio. Example: <code>1</code></p>
            </div>
                    </form>

                <h1 id="autenticacion">Autenticación</h1>

    <p>APIs para la gestión de autenticación de usuarios</p>

                                <h2 id="autenticacion-POSTapi-login">Login</h2>

<p>
</p>

<p>Inicia sesión y devuelve el token de acceso.</p>

<span id="example-requests-POSTapi-login">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://workhub.test/api/login" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"email\": \"camarero@restaurante.com\",
    \"password\": \"password123\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://workhub.test/api/login"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "camarero@restaurante.com",
    "password": "password123"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-login">
            <blockquote>
            <p>Example response (200, success):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;token&quot;: &quot;2|4CzHh0S4Cq8Z9yIBq6lqW9GjQKz...&quot;,
    &quot;user&quot;: {
        &quot;id&quot;: 1,
        &quot;name&quot;: &quot;Juan P&eacute;rez&quot;,
        &quot;email&quot;: &quot;camarero@restaurante.com&quot;,
        &quot;type&quot;: &quot;worker&quot;,
        &quot;created_at&quot;: &quot;2025-02-17T23:39:42.000000Z&quot;,
        &quot;updated_at&quot;: &quot;2025-02-17T23:39:42.000000Z&quot;
    },
    &quot;message&quot;: &quot;Login exitoso&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, credenciales incorrectas):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Las credenciales proporcionadas son incorrectas.&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422, validación fallida):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Error de validaci&oacute;n&quot;,
    &quot;errors&quot;: {
        &quot;email&quot;: [
            &quot;El campo email es obligatorio&quot;
        ],
        &quot;password&quot;: [
            &quot;El campo password es obligatorio&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-login" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-login"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-login"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-login" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-login">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-login" data-method="POST"
      data-path="api/login"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-login', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-login"
                    onclick="tryItOut('POSTapi-login');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-login"
                    onclick="cancelTryOut('POSTapi-login');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-login"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/login</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-login"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-login"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-login"
               value="camarero@restaurante.com"
               data-component="body">
    <br>
<p>Email del usuario. Example: <code>camarero@restaurante.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="POSTapi-login"
               value="password123"
               data-component="body">
    <br>
<p>Contraseña del usuario. Example: <code>password123</code></p>
        </div>
        </form>

                    <h2 id="autenticacion-POSTapi-logout">Logout</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Cierra la sesión del usuario actual invalidando el token.</p>

<span id="example-requests-POSTapi-logout">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://workhub.test/api/logout" \
    --header "Authorization: Bearer {YOUR_AUTH_KEY}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://workhub.test/api/logout"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-logout">
            <blockquote>
            <p>Example response (200, success):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Logout exitoso&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (500, error):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Error al cerrar sesi&oacute;n&quot;,
    &quot;error&quot;: &quot;Mensaje de error detallado&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-logout" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-logout"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-logout"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-logout" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-logout">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-logout" data-method="POST"
      data-path="api/logout"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-logout', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-logout"
                    onclick="tryItOut('POSTapi-logout');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-logout"
                    onclick="cancelTryOut('POSTapi-logout');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-logout"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/logout</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-logout"
               value="Bearer {YOUR_AUTH_KEY}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_KEY}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-logout"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-logout"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

            

        
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                                        <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                                        <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                            </div>
            </div>
</div>
</body>
</html>
