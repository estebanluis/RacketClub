<!DOCTYPE html>
<html>
<head>
    <title>CARNET ALUMNO</title>
    <style>
        @page {
            size: 21cm 29.7cm;
            margin: 0; /* Elimina el margen de la página */
        }
        body {
            margin: 0.25cm; /* Añade un margen de 0.25cm alrededor del cuerpo */
            font-family: 'Arial', sans-serif;
        }
        .container {
            width: 100%;
            height: 100%;
            position: relative;
        }
        .rectangle {
            position: absolute;
            top: 0.25cm; /* Ajusta la posición desde la parte superior en 0.25 cm */
            left: 0.25cm; /* Ajusta la posición desde la izquierda en 0.25 cm */
            width: 7cm;
            height: 5cm;
            border: 1px solid #000;
            background-color: #fff;
            padding: 9px; /* Ajusta el padding para mantener el tamaño total del rectángulo */
            border-radius: 10px;
        }
        
        .title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
            text-align: center;
        }
        .image {
            width: 250px;
            height: 50px;
            float: left;
            margin-right: 10px;
        }
        .name, .schedule {
            font-size: 17px;
            margin-bottom: 10px;
            text-align: center;
        }
        .barcode {
            font-size: 9px;
            display: inline-block;
        }
        .barcode img {
            display: block;
            margin: 0 auto;
        }
        .expiration {
            font-size: 17px;
            text-align: right;
            margin-top: 5px;
            display: inline-block;
        }
        .message {
            font-size: 9px;
            margin-top: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="rectangle">
            <img class="image" src="logos.jpeg" alt="Imagen">
            
            <div class="name">{{ $nom }} {{ $apell }} {{ $apellM }}</div>
            <div class="schedule">{{ $hora }}</div>
            <div class="schedule">{{ $mod }}</div>
            
            <div class="barcode">{!! DNS1D::getBarcodeHTML($codi, 'C128') !!}</div>
            <div class="expiration">Vence: {{ $feVen }}</div>
            
            <div class="message">* Esta tarjeta solo tiene validez por 30 días a partir de su emisión.</div>
        </div>
    </div>
</body>
</html>
