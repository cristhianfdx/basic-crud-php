// Para mantener el código sin acceso desde el navegador

document.addEventListener('DOMContentLoaded', () => {
  const form = document.querySelector('#form');
  const url = 'backend/controllers/front_controller.php';
  let isEdit = false; // Verifica si el usuario se va a editar

  /*------------------------------------------------
   * Interfaz gráfica
   *------------------------------------------------*/

   const initApp = () => getUsers();

  // Mostrar mensaje en pantalla usando boostrap

  const renderMessage = (message, color, seconds) => {
    const div = document.createElement('div');
    div.className = `alert alert-${color} message`;
    div.appendChild(document.createTextNode(message));

    const container = document.querySelector('.card-body');

    container.insertBefore(div, form);

    setTimeout(() => {
      document.querySelector('.message').remove();
    }, seconds);
  };


  const drawTable = data => {
    let template = '';

    data.forEach(user => {
      template += `
        <tr user_id='${user.id}'>
          <td>${user.name}</td>
          <td>${user.email}</td>
          <td>
            <button class='btn btn-sm btn-danger delete'>Eliminar</button>
            <button class='btn btn-sm btn-info edit'>Editar</button>
          </td>
        </tr>
      `;
    });

    document.querySelector('#data').innerHTML = template;
  };

  /*-------------------------------------------------------
   * Envío de datos al servidor
   *------------------------------------------------------*/

  // Función para enviar usuarios al backend
  const postUser = event => {
    const $form = new FormData(form);

    let data = {
      action: 'users',
      user: $form
    };

    if (!isEdit) {
      data.method = 'create-user';

      fetch(`${url}`, {
        method: 'POST',
        body: data,
        headers: {
          'Content-Type': 'application/json'
        }
      })
        .then(res => res.json())
        .then(dataResponse => {
          if (dataResponse.msg === 'created') {
            renderMessage('Usuario creado', 'success', 3000);
            form.reset();
            getUsers();
          }
        })
        .catch(error => {
          console.error(error);
          renderMessage('Ha ocurrido un error en el servidor', 'danger', 3000);
        });
    } else {
      renderMessage('Usuario actualizado', 'info', 3000);
    }

    event.preventDefault();
  };

  form.addEventListener('submit', postUser);

  /*-------------------------------------------------------
   * Obtener de datos del servidor
   *------------------------------------------------------*/

  const getUsers = () => {
    fetch(`${url}?action=users&method=get-users`)
      .then(res => res.json())
      .then(data => {
        drawTable(data);
      });
  };

  initApp();
});
