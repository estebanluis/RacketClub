<?php

namespace App\Http\Controllers;

use App\Models\RegistroAlumno;
use App\Services\TwilioService;
use RealRashid\SweetAlert\Facades\Alert;

class NotificationController extends Controller
{
    protected $twilioService;

    public function __construct(TwilioService $twilioService)
    {
        $this->twilioService = $twilioService;
    }

    public function notify()
    {
        // Obtener todos los usuarios con nrsesiones igual a 0
        $users = RegistroAlumno::where('nrsesiones', 0)->get();
    
        foreach ($users as $user) {
            // Agregar el código de país +591 al número de teléfono
            $phoneNumber = '+591' . $user->telefono;
            $message = "Hola " . $user->nombre . ", tu inscripción ha terminado. Si deseas reinscribirte, por favor pasa por Secretaría.";
            // Enviar el mensaje de WhatsApp
            $this->twilioService->sendWhatsAppMessage($phoneNumber, $message);
        }
        Alert::success('Exito', 'Notificaciones enviadas a los usuarios con 0 numero de sesiones.');
        return redirect()->back();
    }
}
