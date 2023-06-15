<p align="center"><img src="https://s3.eu-south-2.amazonaws.com/katawars.es/app/logo/logo8.png" alt="" /></p>

<h1>Descripción general del proyecto</h1>

<p>Katawars es un proyecto basado en aprendizaje de programación en base a la realización de retos
de programación, o también llamados Katas.</p>

<p>La palabra Kata tiene su origen en el arte marcial Karate, que son posturas repetitivas con diferentes objetivos para memorizar los movimientos
esenciales dentro de cada nivel o cinturón.</p>
<p>Se basa en páginas como Jetbrains Academy, Edabit, y CodeWars.</p>
<p>El objetivo es aprender aspectos fundamentales de la programación, programando.</p>

<h1>Funcionalidades principales de la aplicación</h1>
<p>Superar retos de programación de diversas categorías propuestos por la comunidad, ver recursos de ayuda así como código de los soluciones de otros usuarios y generar tus propios retos de programación.</p>
<p>Los usuarios podrán subir de nivel y éste determinará sus habilidades dentro de la aplicación dónde será necesario alcanzar el máximo nivel para poder crear retos.</p>
<p>Superar sendas (Kataways) que serán colecciones de retos que permitirán al usuario obtener más puntos de experiencia. Se podrán suscribir o desuscribirse para que el sistema contabilice su avance.
Cuando supere todos los retos vinculados obtiene un puntuación extra por racha. También podrá crear sus propias colleciones personalizadas.
</p>

En el aspecto social, los usuarios pueden seguir usuarios y ser seguidos, dar a me gusta a comentarios, recursos o soluciones de otros usuario. También podrán guardar en Favoritos sus retos superados, guardar retos para más tarde y asignarles un orden manual.

Los usuarios pueden publicar recursos de ayuda para otros usuario en los retos.

Los usuarios podrán realizar comentarios a los retos y replicar comentarios de otros usuarios. Disponiendo de un panel centrar para gestionar sus comentarios.

Los usuarios disponen de un chat en tiempo real para comunicarse con los usuarios de la comunidad.

Tienen una página principal en la que se puede ver su progreso, ranking, información genérica así como su actividad en la plataforma.

El usuario puede enviar notificaciones vía email para realizar consultas o denunciar contenido en la plataforma.

Puede realizar donaciones a través de la pasarela de pago de Paypal.

El usuario puede subir 5 fotos de perfil que serán almacenadas en S3 y de las que podrá alternar a su disposición sin necesidad de volver a subirlas. Si sube una sexta se borra la más antigua.

En cualquier momento, el usuario podrá sincronizar su cuenta de Github con su cuenta local en la aplicación.

La aplicación dispone de un panel de administración en el que sólo el usuario administrador
puede acceder y en el que se gestiona las entidades relevantes de la aplicación en todo su extensión.
            
<h1>Objetivos generales</h1>
<ul>
    <li>Casos de uso:
        <ul>
            <li>Invitado:
                <ul>
                    <li> "Registrarse con una cuenta local o con su cuenta de GitHub", "Iniciar sesión con su cuenta local o con su cuenta de GitHub",
                         "Recuperar su contraseña", "Consultar ayuda", "Cambiar de tema", "Consultar términos y condiciones de uso", "Consultar política de privacidad".
                    </li>
                </ul>
            </li>
            <li>Usuario: 
                <ul>
                    <li> "cerrar sesión", "cambiar tema", "subir 5 imagenes de perfil", "seleccionar imagen de perfil del almacén", "eliminar imágenes de perfil", "editar datos perfil", "cambiar contraseña", "activar autenticación en dos pasos, "cerrar sesiones abiertas en otros navegadores", "sincronizar cuenta local con tu cuenta de github", "eliminar usuario", "buscar usuarios", "seguir usuarios", "dejar de seguir usuarios",  "ver actividad del perfil", "ver perfiles de otros usuarios", "subir de nivel", "buscar retos", "filtrar retos por categorias, nivel, estado", "ver página principal del reto", "superar un reto de programación", "comentar en un reto", "editar comentario", "eliminar comentario", "replicar al comentario de otro usuario", "dar like a comentario", "crear un recurso de ayuda para el reto", "editar un recurso", "eliminar un recurso", "dar like a un recurso", "ver soluciones de otros usuarios", "dar like a soluciones", "guardar reto en favoritos", "guardar retos en más tarde", "ordenar manualmente los guardados", "suscribirse a una senda", "desuscribirse a una senda", "superar una senda", "crear una senda", "gestionar todos sus comentarios desde panel de actividad", "enviar
mensajes por chat", "eliminar mensajes de chat", "buscar usuarios de chat", "eliminar conversaciones de chat", "subir fotos al chat", "elegir imagen de perfil de chat", "enviar emoticonos", "cambiar color de chat", "recibir mensajes de chat", "consultar ayuda de la aplicación", "donar dinero con paypal", "enviar notificaciones via email al administrador".</li></ul></li>
            <li> Administrador: 
                <ul>
                    <li> "iniciar sesion", "cerrar sesion", "cambiar tema", "gestión de usuarios", "banear a un usuario", "recuperar un usuario", "gestión de retos creados por un usuario en concreto", "gestión de las sendas creadas por un usuario concreto", "gestión de los recursos aportados por un usuario concreto", "gestión de los comentarios de un usuario concreto", "gestión de los retos", "gestión de las sendas", "gestión de las categorías", "gestión de los rangos", "gestión de las puntuaciones", "gestión de las ayudas".</li></ul></li>
        </ul>
    </li>
</ul>

<h1> Elementos de innovación</h1>
<ul>
    <li> Nube de Amanzon AWS S3 para el almacenamiento de imagenes de perfil, imágenes de la aplicación y los test de los retos.</li>
    <li> Framework Laravel con Jetstream, Fortify y Sanctum.</li>
    <li> Laravel Livewire para la reactividad.</li>
    <li> Laravel Scout configurado con Algolia para búsquedas text-full search de modelos distribuídos por red.</li>
    <li> Laravel Socialité para gestionar el inicio de sesión, registro y sincronización con cuentas de GitHub permitiendo el flujo de aplicación web externo con los servidores de GitHub.</li>
    <li> API Chatify para implementar chat en tiempo real en la aplicación en Laravel.</li>
    <li> API PHPParser para analizar la sintaxis del código introducido por el usuario en los retos y generar su árbol ast para buscar patrones.</li>
    <li> Implementación de API propia llamada "SecurityFilter" para establecer el módulo de seguridad para analizar el código del usuario con base de definiciones de Akamai, Fortinet y Kaspersky.</li>
    <li> Laravel Echo con uso de API de Pusher.js, usando un servidor websocket con conexión full-duplex por protocolo TCP, para permitir el broascasting de eventos en tiempo real (Cambio de Tema y Chat en tiempo real).</li>
    <li> API Spatie Image para permitir el recorte de imagenes en el backend.</li>
    <li> API Spatie Laravel Permission para establecer el sistema de roles y permisos en la aplicación</li>
    <li> Redis Server y Predis para establecer una caché en memoria RAM para gestionar Colas y Jobs, así como procesos en segundo plano de mantenimiento como la subida a Algolia de los modelos para la búsqueda, elimimación de usuarios sin verificar el email después de un tiempo o notificaciones mail para evitar captura de sessión HTTP.</li>
    <li> Uso de Supervisor y sus workers para ejecutar procesos en las colas definidas (default, scout y mail).</li>
    <li> API Paypal para establecer la plataforma de pagos para las donaciones.</li>
    <li> Sortable.js, para poder reordenar los retos manualmente mediante arrastrado de ratón del reto en el la sección de guardados.</li>
    <li> Ace Editor para establecer el parseador y editor de código en frontend para que el usuario introduzca el código.</li>
    <li> Prims.js para resaltar el código de las soluciones de los usuarios.</li>
    <li> Iodine.js (@caneara/iodine) para establecer las validaciones de los formularios en el frontend.</li>
    <li> Axios.js para establecer todo el comportamiento asíncrono de la aplicación.</li>
    <li> Cropper.js para permitir el recorte y manipulación de las imágenes de perfil por los usuarios en el frontend.</li>
    <li> CKEditor.js para permitir la inserción de texto enriquecido en los formularios para generar los enunciados de los retos.<li>
</ul>
