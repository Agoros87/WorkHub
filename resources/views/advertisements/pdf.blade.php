<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>WorkHub - La unión perfecta entre la búsqueda de talento y oportunidades de trabajo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
            background: #f4f4f4;
        }
        .container {
            max-width: 850px;
            margin: 0 auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .workhub-title {
            font-size: 28px;
            font-weight: bold;
            color: #0d6efd;
            text-transform: uppercase;
            background: linear-gradient(to right, #0d6efd, #6610f2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 8px;
        }
        .meta {
            color: #6b7280;
            font-size: 14px;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #374151;
            border-bottom: 2px solid #0d6efd;
            padding-bottom: 6px;
            margin-bottom: 10px;
        }
        .content {
            font-size: 15px;
            color: #555;
        }
        .skills-container {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 8px;
        }
        .skill-tag {
            background-color: #0d6efd;
            color: #fff;
            padding: 6px 12px;
            border-radius: 9999px;
            font-size: 13px;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
        .grid-item {
            padding: 12px;
            background-color: #f8f9fa;
            border-left: 5px solid #0d6efd;
            border-radius: 8px;
            font-size: 15px;
        }
        .grid-full {
            grid-column: span 2;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1 class="workhub-title">WorkHub - La unión perfecta entre la búsqueda de talento y oportunidades de trabajo</h1>
        <h2 class="title">{{ $advertisement->title }}</h2>
        <p class="meta">Publicado por {{ $advertisement->user->company_name ?? $advertisement->user->name }} - {{ $advertisement->created_at->format('d/m/Y') }}</p>
    </div>

    <div class="section grid-full">
        <h2 class="section-title">Descripción</h2>
        <p class="content">{{ $advertisement->description }}</p>
    </div>

    <div class="section grid-full">
        <h2 class="section-title">Ubicación</h2>
        <p class="content">{{ $advertisement->location }}</p>
    </div>

    <div class="section grid-full">
        <h2 class="section-title">Habilidades</h2>
        <div class="skills-container">
            @foreach(is_array($advertisement->skills) ? $advertisement->skills : explode(',', $advertisement->skills) as $skill)
                <span class="skill-tag">{{ trim($skill) }}</span>
            @endforeach
        </div>
    </div>

    <div class="grid">
        @if($advertisement->type === 'employer')
            <div class="grid-item">
                <h2 class="section-title">Horario</h2>
                <p class="content">{{ $advertisement->schedule }}</p>
            </div>
            <div class="grid-item">
                <h2 class="section-title">Tipo de Contrato</h2>
                <p class="content">{{ $advertisement->contract_type }}</p>
            </div>
            <div class="grid-item grid-full">
                <h2 class="section-title">Salario</h2>
                <p class="content">{{ number_format($advertisement->salary, 2, ',', '.') }} €/año</p>
            </div>
        @else
            <div class="grid-item">
                <h2 class="section-title">Disponibilidad</h2>
                <p class="content">{{ $advertisement->availability }}</p>
            </div>
            <div class="grid-item">
                <h2 class="section-title">Expectativa Salarial</h2>
                <p class="content">{{ number_format($advertisement->salary_expectation, 2, ',', '.') }} €/año</p>
            </div>
        @endif
    </div>
</div>
</body>
</html>
