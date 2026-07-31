const input      = document.getElementById('nuevaTarea');
const btnAgregar = document.getElementById('btnAgregar');
const lista      = document.getElementById('listaTareas');

function crearElementoTarea(tarea) {
  const li = document.createElement('li');
  li.dataset.id = tarea.id;
  if (tarea.completada) li.classList.add('completada');

  const span = document.createElement('span');
  span.classList.add('texto');
  span.textContent = tarea.texto;

  span.addEventListener('click', () => toggleCompletar(li, tarea.id));

  const btn = document.createElement('button');
  btn.classList.add('btnEliminar');
  btn.textContent = 'Eliminar';
  btn.addEventListener('click', () => eliminarTarea(li, tarea.id));

  li.appendChild(span);
  li.appendChild(btn);
  return li;
}

// Vincular eventos a las tareas ya renderizadas por PHP
document.querySelectorAll('#listaTareas li').forEach(li => {
  const id   = parseInt(li.dataset.id);
  const span = li.querySelector('.texto');
  const btn  = li.querySelector('.btnEliminar');

  span.addEventListener('click', () => toggleCompletar(li, id));
  btn.addEventListener('click',  () => eliminarTarea(li, id));
});

async function agregarTarea() {
  const texto = input.value.trim();
  if (texto === '') {
    alert('Escribe una tarea primero.');
    return;
  }

  const res  = await fetch('api/agregar.php', {
    method:  'POST',
    headers: { 'Content-Type': 'application/json' },
    body:    JSON.stringify({ texto }),
  });

  const data = await res.json();
  if (data.error) { alert(data.error); return; }

  lista.appendChild(crearElementoTarea(data));
  input.value = '';
  input.focus();
}

async function eliminarTarea(li, id) {
  const res  = await fetch('api/eliminar.php', {
    method:  'POST',
    headers: { 'Content-Type': 'application/json' },
    body:    JSON.stringify({ id }),
  });

  const data = await res.json();
  if (data.success) li.remove();
}

async function toggleCompletar(li, id) {
  const completada = li.classList.contains('completada') ? 0 : 1;

  const res  = await fetch('api/completar.php', {
    method:  'POST',
    headers: { 'Content-Type': 'application/json' },
    body:    JSON.stringify({ id, completada }),
  });

  const data = await res.json();
  if (data.success) li.classList.toggle('completada');
}

btnAgregar.addEventListener('click', agregarTarea);
input.addEventListener('keypress', e => {
  if (e.key === 'Enter') agregarTarea();
});
