# VUE TEMPLATE

Este proyecto es una **plantilla** para aplicaciones desarrolladas con Vue.js. Incluye un conjunto de librerías, componentes y páginas que facilitan el desarrollo de aplicaciones con Vue.js. la plantilla utiliza librerías y módulos como [PrimeVue](https://www.primefaces.org/primevue/ "PrimeVue"), [Quasar](https://quasar.dev/ "Quasar"), [Pinia](https://pinia.vuejs.org/getting-started.html "Pinia"), [Axios](https://axios-http.com/ "Axios"), [CryptoJS](https://cryptojs.gitbook.io/docs/ "CryptoJS"), [GSAP](https://greensock.com/docs/ "GSAP"), [Vue Router](https://router.vuejs.org/ "Vue Router"), entre otros. La **plantilla** está diseñada para ser fácilmente personalizable y extensible, permitiendo a los desarrolladores ahorrar tiempo y esfuerzo al crear sus aplicaciones. Las librerías, componentes y páginas incluidas en la plantilla están probadas y optimizadas para ofrecer un rendimiento óptimo en diferentes dispositivos y navegadores. La plantilla también incluye un conjunto completo de herramientas de desarrollo y documentación para ayudar a los desarrolladores a comenzar rápidamente y de manera eficiente.

## Índice

| Sección | Descripción |
| :------------: | ---          |
| [Instalación][1] | El manual proporciona instrucciones detalladas sobre cómo configurar y poner en marcha la plataforma en un servidor. Se ofrecen varias opciones para descargar el proyecto, incluyendo clonar el repositorio usando HTTPS o SSH, o descargar el código fuente como un archivo ZIP. Una vez que se cuenta con el proyecto en la computadora, se indica el comando para instalar las dependencias, módulos y librerías necesarios. |
| [Uso][2] | Una vez que se han completado los pasos de instalación, se proporcionan instrucciones para iniciar el servidor de desarrollo y compilar el proyecto. También se describe cómo ejecutar pruebas unitarias en el código para garantizar su correcto funcionamiento. |
| [Funciones relevantes][3] | Se describe el uso de funciones "externas" en el proyecto. |
| [Librerías][4] | Se enumeran y explican las librerías utilizadas en el proyecto, detallando su uso y cómo se integran en el código. |
| [Carpetas y archivo que se descargan por defecto][5] | Se proporciona una imagen del árbol de archivos y carpetas descargados por defecto. |
| [Archivos de configuración][6] | Se explica el uso de archivos de configuración para establecer opciones de configuración en la aplicación. |
| [Archivo LICENSE: MIT][7] | Se explica el propósito del archivo LICENSE en repositorios de Git y detalla un poco más acerca de la licencia que **sólo abarca la plantilla**. |
| [Archivo .deleteThis][8] | Se describe el uso del archivo .deleteThis como archivo de muestra en repositorios de Git. |
| [Carpetas][9] | Se explica el propósito de la carpetas predeterminadas del proyecto. |
| [Reglas generales de desarrollo][10] | Se proporciona información sobre las reglas generales de desarrollo para el proyecto. |

## Instalación

La sección de instalación de **la plantilla** proporciona una guía detallada sobre cómo configurar y poner en marcha la plataforma en su servidor. A continuación, se proporcionan los pasos necesarios para completar la instalación y comenzar a utilizar la plataforma web. Asegúrese de seguir cuidadosamente cada paso para garantizar una instalación correcta y sin problemas.

Existen varias opciones para descargar el proyecto:

1. __Clonar el repositorio usando HTTPS:__ en la página del repositorio, busca el botón "Clone or download" y haz clic en él. Se desplegará una ventana con un enlace de clonado. Copia el enlace y utiliza el comando `git clone` en tu terminal para clonar el repositorio en tu computadora. Por ejemplo:

    ```bash
    git clone https://github.com/Santiago1010/template-vue
    ```

2. __Clonar el repositorio usando SSH:__ para clonar el proyecto con SSH, recuerda que debes tener configurada tu clave pública y privada tanto en git, como en GitHub. En la página del repositorio, busca el botón "Clone or download" y haz clic en él. Se desplegará una ventana en la que deberás elegir la opción ***SSH***. Copia el enlace y utiliza el comando `git clone` en tu terminal para clonar el repositorio en tu computadora. Por ejemplo:

	```bash
	git clone git@github.com:Santiago1010/template-vue.git
	```

3. __Clonar el proyecto descargando el código fuente:__ si por el contrario, no deseas utilizar git, puedes buscar el botón "Clone or download" y hacer clic en él. Se desplegará una ventana en la que deberás elegir la opción "Download ZIP".

Después de contar con el proyecto en tu computador, debes acceder a ella desde la terminal. Por ejemplo:

```bash
cd ~/Documentos/Proyectos/Vue/template-vue
```

### Instalación de dependencias, módulos y librerías

La instalación de dependencias, módulos y librerías es un paso importante en el desarrollo de cualquier aplicación o proyecto de software. Estos componentes nos permiten aprovechar el trabajo de otros desarrolladores y ampliar las funcionalidades de nuestro código, lo que nos permite crear aplicaciones más complejas y poderosas. En esta sección, explicaremos cómo instalar estos componentes en distintos sistemas operativos y entornos de programación.

Una vez clonado el proyecto y haber accedido a la carpeta del mismo, utiliza el siguiente comando en tu terminal:
```bash
npm install
```

Lo cuál, iniciará el proceso de instalación de todas las dependencias, módulos y librerías que requiere **la plantilla** para su correcto funcionamiento.

## Uso

Iniciar el servidor de desarrollo y compilar el proyecto son pasos fundamentales en el desarrollo de una aplicación o proyecto de software. Estos procesos nos permiten ejecutar y probar nuestro código en un entorno de desarrollo, lo que nos permite detectar errores y hacer cambios en tiempo real. Además, la compilación del proyecto nos permite convertir nuestro código fuente en una versión ejecutable que puede ser utilizada por otros usuarios. En esta sección, se explica cómo iniciar el servidor de desarrollo y compilar el proyecto en distintos entornos de programación.

### Iniciar el servidor

Una vez instalado el código fuente y las dependencias, módulos y librerías correspondientes, puedes abrir la interfaz gráfica con el siguiente comando:

```bash
npm run dev
```

Una vez el servidor haya iniciado, se te mostrará un link que te permitirá acceder a la interfaz gráfica.

### Construir la versión de producción

Para generar la versión que será alojada en el servidor de producción (o pre-producción), es necesario utilizar el siguiente comando:

```bash
 npm run build
```

Esto generará una carpeta llamada ***dist***, en la cuál se contrarán los archivos que deben ser alojados en el servidor.

## Funciones relevantes

**La plantilla** utiliza ciertas funciones "externas" para su correcto funcionamiento, por lo que en esta sección, se procederá a explicar cómo funcionan cada una de estas.

- __AES.js:__ Esta función, se encarga de generar una encriptación desde el lado del cliente y que posteriormente será utilizada para enviar información encriptada.
- __Security.js:__ Esta función se encarga de gestionar la seguridad desde el lado del cliente; recibiendo y enviando información encriptada con SHA256 y parseando el JWT recibido desde el servidor.

> Estas 2 funciones se pueden encontrar en la ruta: `@src/assets/functions/`

- __axios.js:__ Este archivo genera una constante que contiene la ruta base para consumir la API de la aplicación.
- __router.js:__  En este archivo se almacenan las configuraciones de las rutas manejjadas en la aplicación.

> Estas 2 funciones se pueden encontrar en la ruta: `@src/assets/plugins/`

- __rulesStore.js:__ Función que almacena y gestiona el estado de las reglas en toda la aplicación.

> Estas función se puede encontrar en la ruta: `@src/assets/store/`

## Librerías
Las librerías son componentes de código que nos permiten aprovechar el trabajo de otros desarrolladores y ampliar las funcionalidades de nuestro proyecto de software. En esta sección, enumeraremos y explicaremos las librerías utilizadas en nuestro proyecto, detallando para qué se utilizan y cómo se integran en nuestro código. Esto nos permitirá conocer mejor las herramientas que estamos utilizando y cómo aprovechar al máximo su potencial.

- __[Quasar](https://quasar.dev/ "Quasar"):__ Es un framework de UI y UX basado en VueJS. En este proyecto, es utilizado como la principal fuente de componentes y estilos.
- __[Axios](https://axios-http.com/ "Axios"):__ Axios es una librería de JavaScript que se utiliza para realizar solicitudes HTTP de manera sencilla y eficiente. En la aplicación es la principal forma de consumir la API de la aplicación.
- __[CryptoJS](https://cryptojs.gitbook.io/docs/ "CryptoJS"):__ Es una librería que permite hacer encriptaciones y codificaciones desde JavaScript. Para este proyecto, es utilizado para encriptar la contraseña, descifrar wl JWT y demás.
- __[GSAP](https://greensock.com/gsap/ "GSAP"):__ Es una biblioteca de animación JavaScript que se utiliza para crear animaciones en sitios web y aplicaciones móviles. En el proyecto, es utilizado para realizar ciertas animaciones menores en la menor cantidad de tiempo de ejecución posible.
- __[Pinia](https://pinia.vuejs.org/ "Pinia"):__ Es una librería avanzada de manejo de estado adaptada especialmente para Vue. En este proyecto, es utilizado para la gestión de estado.
- __[PrimeVue](https://www.primefaces.org/primevue/ "PrimeVue"):__ PrimeVue es un componente de interfaz de usuario basado en Vue.js que se utiliza para crear aplicaciones web modernas y atractivas. En el proyecto es utilizado como fuente de componentes adicional.

## Carpetas y archivo que se descargan por defecto

[![Árbol de archivos y carpetas](https://i.imgur.com/Rzlnhz8.png "Árbol de archivos y carpetas")](https://i.imgur.com/Rzlnhz8.png "Árbol de archivos y carpetas")

## Archivos de configuración
Los **archivos de configuración** son archivos especiales que contienen la información necesaria para configurar una aplicación o sistema. En un entorno de plataforma web cliente, los archivos de configuración pueden contener información como la ruta del servidor backend, la configuración de autenticación y autorización, o la configuración de opciones de desarrollo. Esta información se utiliza por la aplicación web cliente para interactuar con el servidor backend y proporcionar la funcionalidad deseada. Los archivos de configuración también se pueden utilizar para establecer opciones de configuración de la aplicación, como el idioma predeterminado o la apariencia de la interfaz de usuario.

### .env.example
Un archivo ***.env.example*** es un archivo de muestra que se utiliza para proporcionar una plantilla para un archivo de configuración llamado ***.env***. Este archivo contiene un conjunto de **variables de entorno y sus valores predeterminados**, que pueden ser utilizados por una aplicación para configurarse y funcionar correctamente. El archivo ***.env.example*** se utiliza como plantilla para crear un archivo ***.env*** real que contenga los valores de configuración específicos para un entorno de desarrollo o producción. Una vez que se ha creado el archivo ***.env***, reemplaza al archivo ***.env.example*** y se utiliza en su lugar.

Un archivo ***.env*** es un archivo de configuración que contiene un conjunto de variables de entorno y sus valores. Este archivo se utiliza para configurar una aplicación y permitir que funcione correctamente en un entorno de desarrollo o producción específico. Los valores de configuración contenidos en el archivo .env se cargan en la aplicación cuando se inicia, y se utilizan para configurar opciones como la ruta del servidor backend, la configuración de autenticación y autorización, y la configuración de opciones de desarrollo. El archivo ***.env*** también se puede utilizar para establecer opciones de configuración de la aplicación, como el idioma predeterminado o la apariencia de la interfaz de usuario.

> Recuerda que el archivo *.env* que crearás debe estar en la carpeta raíz del proyecto para que [vite.js](https://vitejs.dev/guide/env-and-mode.html "vite.js") lo pueda reconocer.

### .editorconfig

Un archivo ***.editorconfig*** es un archivo de configuración que se utiliza para establecer y mantener un conjunto uniforme de reglas de formateo y estilo para los archivos de un proyecto de desarrollo de software. Estas reglas pueden incluir cosas como la longitud máxima de línea, la indentación, el uso de espacios o tabs, o el estilo de comentario. El archivo ***.editorconfig*** se utiliza para asegurarse de que todos los desarrolladores que trabajan en un proyecto utilicen el mismo conjunto de reglas de formateo y estilo, lo que facilita la lectura y el mantenimiento del código fuente. Muchos editores de código y herramientas de desarrollo tienen soporte para ***.editorconfig*** y pueden leer y utilizar las reglas contenidas en el archivo para formatear y estilizar automáticamente el código.

En el ***.editorconfig*** de este proyecto, se deben seguir las siguientes reglas:

1. La opción `end_of_line` se establece en **"lf"**, lo que significa que el carácter de fin de línea deberá ser un salto de línea (LF) y no un retorno de carro (CR) o un retorno de carro y salto de línea (CRLF).
2. La opción `insert_final_newline` se establece en **"false"**, lo que significa que los archivos no deben contener una línea en blanco al final del contenido.
3. La opción `indent_style` se establece en **"tab"**, lo que significa que la indentación en el código deberá ser realizada mediante la utilización de caracteres de tabulación en lugar de espacios.
4. La opción `indent_size` se establece en **"4"**, lo que significa que cada nivel de indentación deberá estar compuesto por 4 caracteres de tabulación.
5. La opción `charset` se establece en **"utf-8"** para los archivos con las extensiones .js, .py, .vue y .php, lo que significa que estos archivos deben estar codificados en UTF-8.

### .gitignore

Un archivo .gitignore es un archivo que se utiliza en repositorios de Git para indicar qué archivos o carpetas no deben incluirse en el control de versiones. Esto puede ser útil, por ejemplo, si hay archivos que no quieres que se guarden en tu repositorio, como archivos de configuración que contienen información confidencial o archivos que se generan automáticamente y que no necesitan ser controlados por Git.

El archivo .gitignore del proyecto contiene una serie de reglas que indican qué archivos o carpetas deben ser ignorados por Git. Estas reglas están divididas en diferentes secciones, cada una de las cuales se refiere a un tipo de archivo o carpeta en particular. Aquí te explicaré brevemente algunas de las reglas que se incluyen en el archivo:

- En la sección ***"Android"***, se encuentran reglas para ignorar archivos generados por Android Studio, como los archivos de configuración local.properties o los archivos de proyecto IntelliJ (.iml). También se ignoran los archivos de log y los archivos de almacén de claves (.jks, .keystore).
- En la sección ***"dotenv"***, se indica que se deben ignorar los archivos .env, que a menudo se utilizan para almacenar variables de entorno.
- En la sección ***"Images"***, se encuentran reglas para ignorar diferentes tipos de archivos de imagen, como JPEG, PNG o GIF.
- En la sección ***"Linux"***, se incluyen reglas para ignorar archivos temporales que pueden generarse en sistemas Linux, así como archivos de configuración de KDE.
- En la sección ***"macOS"***, se ignoran archivos generados por macOS, como el archivo .DS_Store o el archivo Icon. También se ignoran carpetas como ***"Trash"*** o ***"Temporary Items"***.
- En la sección ***"MicrosoftOffice"***, se ignoran archivos temporales generados por aplicaciones como Word o Excel.
- En la sección ***"Video"***, se ignoran diferentes tipos de archivos de vídeo, como AVI, MP4 o WMV.
- En las secciones ***"Vue"*** y ***"Vuejs"***, se ignoran archivos y carpetas generados por aplicaciones Vue.js, como node_modules o dist/.
- En la sección ***"Windows"***, se ignoran archivos generados por Windows, como Thumbs.db o el archivo Icon.

### index.html
El archivo `index.html` es el punto de partida para cualquier aplicación de Vue, ya que define la estructura básica de la aplicación y permite cargar los diferentes componentes y librerías que se utilizan en la aplicación.

### package-lock.json

El archivo **package-lock.json** es un archivo que se genera automáticamente en proyectos de Node.js que utilizan el administrador de paquetes *npm*. Este archivo contiene un registro de todas las dependencias de un proyecto, así como sus versiones exactas.

La principal ventaja de utilizar el archivo **package-lock.json** es que permite asegurarse de que todos los desarrolladores que trabajen en un proyecto estén utilizando la misma versión de las dependencias. Además, el archivo **package-lock.json** también hace que sea más fácil reproducir entornos de desarrollo, ya que permite instalar las dependencias de un proyecto de manera exacta y determinista.

En resumen, el archivo **package-lock.json** es un archivo que se utiliza en proyectos de *Node.js* para registrar y mantener un historial de las dependencias y sus versiones exactas. Esto permite asegurarse de que todos los desarrolladores que trabajen en un proyecto estén utilizando la misma versión de las dependencias, lo que facilita la reproducción de entornos de desarrollo.

### package.json
El archivo **package.json** es un archivo que se utiliza en proyectos de *Node.js* para registrar información sobre el proyecto, así como también las dependencias que utiliza. Este archivo suele incluir información como el nombre del proyecto, su versión, una descripción del proyecto, así como también la lista de dependencias que utiliza y scripts que se pueden ejecutar.

El archivo **package.json es esencial para cualquier proyecto de Node.js**, ya que permite gestionar las dependencias del proyecto de manera sencilla. Por ejemplo, cuando se utiliza el comando `npm install` para instalar las dependencias de un proyecto, *npm* utiliza el archivo **package.json** para saber qué dependencias deben instalarse. Además, el archivo **package.json** también permite definir scripts que se pueden ejecutar de manera sencilla utilizando el comando `npm run`.

En resumen, el archivo **package.json** es un archivo fundamental en proyectos de *Node.js*, ya que permite gestionar las dependencias del proyecto y definir scripts que se pueden ejecutar de manera sencilla.

### vite.config.js
El archivo **vite.config.js** es un archivo de configuración que se utiliza en proyectos que utilizan el servidor de desarrollo [Vite](https://vitejs.dev/guide/ "Vite"). Este archivo permite personalizar la configuración del servidor de acuerdo a las necesidades del proyecto.

Este archivo utiliza la función `defineConfig` de [Vite](https://vitejs.dev/guide/ "Vite") para definir diferentes opciones y ajustes para el servidor de desarrollo.

En este caso en particular, el archivo **vite.config.js** está configurado para utilizar dos *plugins*: el **plugin vue**, que permite utilizar **Vue.js** en la aplicación, y el plugin **quasar**, que permite utilizar la **librería Quasar** en la aplicación. Además, se establece una opción específica para el plugin vue, que indica que se debe utilizar la función `transformAssetUrls` para transformar las URLs de los assets en **plantillas de Vue**. También se establece una opción específica para el plugin quasar, que indica la ruta del archivo que contiene las variables SASS que se utilizarán en la aplicación.

## Archivo LICENSE: MIT

El archivo **LICENSE** es un archivo que suele incluirse en *repositorios de Git* para especificar los términos y condiciones de la licencia que cubre el proyecto. Esta licencia puede ser una licencia pública, como la licencia MIT, o una licencia propietaria.

En el caso de esta plantilla, e trata de una **licencia MIT** que cubre el software que has desarrollado, y que está siendo distribuido bajo los términos y condiciones de esta licencia.

> Es importante tener en cuenta que la licencia MIT sólo cubre el software original, y no cubre las obras derivadas que puedan resultar del uso, modificación o distribución del software.

### MIT License
La **licencia MIT** es una licencia pública que permite a cualquier persona utilizar, modificar y distribuir el software cubierto por esta licencia, siempre y cuando se incluya una copia de la licencia y se den créditos al autor original del software. Además, la licencia MIT no otorga ninguna garantía sobre el software y exime a los autores de toda responsabilidad en caso de que se produzca algún daño.

La **licencia MIT** es una licencia muy permissiva que permite a cualquier persona utilizar el software de manera libre, siempre y cuando se respeten los términos y condiciones de la licencia.

En resumen, la **licencia MIT** es una licencia pública que permite a cualquier persona utilizar, modificar y distribuir el software cubierto por esta licencia, siempre y cuando se respeten los términos y condiciones de la licencia. **Sin embargo, esta licencia solo cubre el software original, y no cubre las obras derivadas que puedan resultar del uso, modificación o distribución del software.**

## Archivo .deleteThis

El archivo ***.deleteThis*** es un archivo de muestra que se utiliza para mostrar cómo se cargan las carpetas en GitHub. Este archivo no tiene relevancia en el funcionamiento del proyecto y se puede eliminar con tranquilidad.

## Carpetas

### Carpeta Source (/src/)
La carpeta **src** es una carpeta común en proyectos de **Vue** que utilizan [vite.js](https://vitejs.dev/guide/env-and-mode.html "vite.js"). Esta carpeta suele contener todos los archivos fuente de la aplicación, incluyendo archivos de componentes, archivos de estilo, archivos de páginas, archivos de configuración, y otros archivos relacionados con la aplicación. La carpeta src se utiliza para organizar y mantener los archivos fuente de la aplicación, y es donde se desarrolla y se realizan cambios en la aplicación.

> Las carpetas que se encuentran dentro de /src/ ([assets](https://github.com/Santiago1010/template-vue/blob/main/src/assets/ASSETS.md "assets"), [components](https://github.com/Santiago1010/template-vue/blob/main/src/components/COMPONENTS.md "components"), [layouts](https://github.com/Santiago1010/template-vue/blob/main/src/layouts/LAYOUTS.md "layouts"), [pages](https://github.com/Santiago1010/template-vue/blob/main/src/pages/PAGES.md "pages")), cuentan con su respectivo archivo de información, al que podrás acceder haciendo click en cada uno de los nombres de la carpeta.

#### Archivo App.vue
El archivo **App.vue** se utiliza para definir la estructura y el comportamiento básico de la interfaz de usuario de la aplicación y es el componente que se renderiza cuando se carga la aplicación.

### Archivo main.js
El archivo **main.js** es un archivo de configuración principal en un proyecto de **Vue**. Este archivo contiene código que se ejecuta al inicio de la aplicación y es donde se inicializa la instancia principal de **Vue**. También se pueden importar y configurar otros módulos y plugins en este archivo. El archivo **main.js** es el punto de entrada de la aplicación y se utiliza para configurar y ejecutar la aplicación de **Vue**.

## Reglas generales de desarrollo

1. Los archivos .vue deben nombrarse siguiendo la convención **PascalCase**, es decir, que cada palabra en el nombre del archivo comience con una letra mayúscula. Por ejemplo: **"App.vue"** o **"LoginForm.vue"**.
2. Los archivos deben organizarse en carpetas y subcarpetas de manera lógica y coherente. Por ejemplo, se podría tener una carpeta "components" que contenga los componentes reutilizables de la aplicación, y una carpeta "pages" que contenga los componentes de página de la aplicación; o los archicos .png vayan la sub carpeta correspndiente dentro de `@src/assets/images`.
3. Las variables y funciones en los archivos .vue, y .js deben nombrarse siguiendo la convención camelCase, es decir, que las palabras en el nombre de la variable o función comiencen con una letra minúscula, excepto la primera palabra. Por ejemplo: **"firstName"** o **"calculateTotal"**.
4. Los archivos .vue deben estructurarse siguiendo la arquitectura recomendada por Vue.js, con una etiqueta `<template>` para definir la estructura de la interfaz de usuario, una etiqueta `<script setup>` para definir la lógica de la aplicación y una etiqueta `<style scoped>` para definir los estilos CSS sin afectar a los demás.
5. Es importante utilizar las herramientas de desarrollo de Vite.js para depurar y optimizar la aplicación, y para asegurarse de que el código cumpla con los estándares de calidad y rendimiento.
6. Es recomendable utilizar componentes y librerías de terceros, como PrimeVue, Quasar y Pinia, siempre que sea necesario y que se ajusten a las necesidades y requerimientos del proyecto.
7. Todos los nombres de archivos y carpetas, nombres de variables y funciones y cualquier otro elemento relacionado con la programación deben escribirse en inglés.

[1]: https://github.com/Santiago1010/template-vue#instalaci%C3%B3n "Instalación"
[2]: https://github.com/Santiago1010/template-vue#uso "Uso"
[3]: https://github.com/Santiago1010/template-vue#funciones-relevantes "Funciones relevantes"
[4]: https://github.com/Santiago1010/template-vue#librer%C3%ADas "Librerías"
[5]: https://github.com/Santiago1010/template-vue#carpetas-y-archivo-que-se-descargan-por-defecto "Carpetas y archivo que se descargan por defecto"
[6]: https://github.com/Santiago1010/template-vue#archivos-de-configuraci%C3%B3n "Archivos de configuración"
[7]: https://github.com/Santiago1010/template-vue#archivo-license-mit "Archivo LICENSE: MIT"
[8]: https://github.com/Santiago1010/template-vue#archivo-deletethis "Archivo .deleteThis"
[9]: https://github.com/Santiago1010/template-vue#carpetas "Carpetas"
[10]: https://github.com/Santiago1010/template-vue#reglas-generales-de-desarrollo "Reglas generales de desarrollo"