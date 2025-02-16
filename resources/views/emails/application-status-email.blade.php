<!DOCTYPE html>
<html>
<head>
    <title>Actualización de Estado de Aplicación</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding: 20px;">
<h1 style="color: #2d3748;">Actualización de Estado de Aplicación</h1>

<p>Hola {{ $jobApplication->user->name }},</p>

<p>El estado de tu aplicación para el puesto "{{ $jobApplication->advertisement->title }}" ha sido actualizado.</p>

<p>
    <strong>Estado anterior:</strong> {{ $oldStatus }}<br>
    <strong>Nuevo estado:</strong> {{ $newStatus }}
</p>

<p>Puedes ver más detalles de tu aplicación haciendo clic en el siguiente enlace:</p>

<p>
    <a href="{{ route('job-applications.show', $jobApplication) }}"
       style="display: inline-block; background-color: #3490dc; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px;">
        Ver Aplicación
    </a>
</p>

<p>
    Gracias por usar WorkHub,<br>
    {{ config('app.name') }}
</p>
</body>
</html>
