<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Encuesta;
use App\Models\Pregunta;
use App\Models\Propiedades;
use App\Models\Respuesta;
use App\Models\Servicio;
use App\Models\ServiciosTipo;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class CitaController extends Controller
{
    public function index($id, $mes = null, $dia = null)
    {
        if (!$mes) {
            $mesRed = date("Y-m");
            $diaRed = date("j");
            return Redirect::route('usuario.citas.index', ['id' => $id, 'mes' => $mesRed, 'dia' => $diaRed]);
        }
        $meses = $this->ultimosMeses(3, true, true);
        $diasHabiles = null;

        if ($mes != null) {
            list($Anio, $Mes) = explode('-', $mes);
            $year = $Anio;
            $month = $Mes;
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $Mes, $year);
            $iDay = 1;
            if (date('m') == $month) {
                $iDay = date('j');
            }
            for ($day = $iDay; $day <= $daysInMonth; $day++) {
                $date = new \DateTime("$year-$month-$day");
                $dayOfWeek = $date->format('N'); // 1 (lunes) a 7 (domingo)

                if ($dayOfWeek < 6) { // 1 a 5 son días hábiles (lunes a viernes)
                    $diasHabiles[] = $day;
                }
            }
        }
        $horas = null;
        if ($dia != null) {
            $hanio = $Anio;
            $hmes = $Mes;
            $hdia = $dia;
            $horas = $this->generateTimes($hanio, $hmes, $hdia);
        }
        $citas = Cita::with('propiedad')->where('usuario_id', auth()->id())->get();
        $propiedad = Propiedades::findOrFail($id);
        $controlCitaPropiedad = Cita::getCitasControlByPropiedad($id);
        $ultimaCita = Cita::with('propiedad')
            ->where('id_propiedad', $id)
            ->where('usuario_id', auth()->id())
            ->where('estado', 'pendiente') // Filtrar solo citas pendientes
            ->orderBy('created_at', 'desc') // Ordenar de la más reciente a la más antigua
            ->first(); // Obtener solo la última
        return view('web.home.citas', [
            'propiedad' => $propiedad,
            'citas' => $citas,
            'id' => $id,
            'meses' => $meses,
            'smes' => $mes,
            'dias' => $diasHabiles,
            'sdia' => $dia,
            'horas' => $horas,
            'controlpropiedad' => $controlCitaPropiedad,
            'ultimaCita' => $ultimaCita
        ]);
    }

    public function all_citas_user()
    {
        $citas = Cita::where('usuario_id', auth()->id())->get();
        // Devuelves las citas en formato JSON, junto con un mensaje de éxito
        return response()->json(['status' => 'success', 'data' => $citas]);
    }

    public function encuesta($cita, $prop)
    {
        $propiedad = Propiedades::findOrFail($prop);
        //Verificamos si hay respuestas
        $respuestas = Respuesta::join('preguntas', 'respuestas.respuesta_id', '=', 'preguntas.id')
            ->join('encuestas', 'preguntas.encuesta_id', '=', 'encuestas.id')
            ->where('respuestas.cita_id', $cita)
            ->get();
        //Respuesta::obtenerRespuestasPorCita($cita);
        // Iterar sobre las respuestas y mostrar los datos
        $respuestas2 = "";
        $encuestas = null;
        //dd($respuestas);
        if ($respuestas->count() == 0) {
            $fechaLimite = '2025-12-20';
            $encuestas = Encuesta::encuestasHabilitadasHasta($fechaLimite);
        } else {
            foreach ($respuestas as $respuesta) {
                $respuestas2 .= '<h5>' . $respuesta->nombre . " '" . $propiedad->nombre . "'</h5>";
                $respuestas2 .= $respuesta->pregunta . "<br>";
            }
        }
        return view('web.home.citas_encuesta', ['cita' => $cita, 'prop' => $prop,  'encuestas' => $encuestas, 'propiedad' => $propiedad, 'respuestas' => $respuestas2]);
    }

    public function index_admin()
    {
        $citas = Cita::with(['propiedad', 'user'])->get();
        return view('admin::citas.index', ['citas' => $citas]);
    }
    public function admin_cita_encuesta(Request $request)
    {
        $prop = $request->idProp;
        $propiedad = Propiedades::findOrFail($prop);
        $cita = $request->idCita;
        $respuestas = Respuesta::join('preguntas', 'respuestas.respuesta_id', '=', 'preguntas.id')
            ->join('encuestas', 'preguntas.encuesta_id', '=', 'encuestas.id')
            ->where('respuestas.cita_id', $cita)
            ->get();

        $respuestas2 = "";
        if ($respuestas->count() > 0) {
            foreach ($respuestas as $respuesta) {
                $respuestas2 .= '<h5>' . $respuesta->nombre . " '" . $propiedad->nombre . "'</h5>";
                $respuestas2 .= $respuesta->pregunta . "<br>";
            }
        }
        return view('admin::citas.ajax.cita_encuesta', ['respuestas' => $respuestas2]);
    }

    public function admin_cita_encuesta_graficas()
    {
        $mesesPasados = $this->ultimosMeses();
        $fechaLimite = '2025-05-30';
        $encuestas = Encuesta::encuestasHabilitadasHasta($fechaLimite);
        //Grafica 1
        $encuenstaNombre[0] = $encuestas[0]->nombre;
        $preguntas1 = Pregunta::preguntasPorEncuesta($encuestas[0]->id);
        $j = 0;
        foreach ($preguntas1 as $pregunta) {
            $textoSalida1[$j] = "[";
            $textoPregunta1[$j] = $pregunta->pregunta;
            $cadenaMeses = '[';
            for ($i = 0; $i < count($mesesPasados); $i++) {
                $cadenaMeses .= "'" . $mesesPasados[$i] . "', ";
                $respuestas1 = Respuesta::obtenerRespuestasPorPregunta($mesesPasados[$i], $pregunta->id);
                if ($respuestas1 != null) {
                    $textoSalida1[$j] .= $respuestas1[0]->resultado . ", ";
                } else {
                    $textoSalida1[$j] .= "0, ";
                }
            }
            $cadenaMeses = rtrim($cadenaMeses, ', ');
            $cadenaMeses .= ']';
            //
            $textoSalida1[$j] = rtrim($textoSalida1[$j], ', ');
            $textoSalida1[$j] .= ']';
            $j++;
        }
        //Grafica 2
        $encuenstaNombre[1] = $encuestas[0]->nombre;
        $preguntas2 = Pregunta::preguntasPorEncuesta($encuestas[0]->id);
        $j = 0;
        foreach ($preguntas2 as $pregunta) {
            $textoSalida2[$j] = "[";
            $textoPregunta2[$j] = $pregunta->pregunta;
            for ($i = 0; $i < count($mesesPasados); $i++) {
                $respuestas2 = Respuesta::obtenerRespuestasPorPregunta($mesesPasados[$i], $pregunta->id);
                if ($respuestas2 != null) {
                    $textoSalida2[$j] .= $respuestas2[0]->resultado . ", ";
                } else {
                    $textoSalida2[$j] .= "0, ";
                }
            }
            $textoSalida2[$j] = rtrim($textoSalida2[$j], ', ');
            $textoSalida2[$j] .= ']';
            $j++;
        }
        return view('admin::citas.encuestas_graficas', ['meses' => $cadenaMeses, 'encuestas' => $encuenstaNombre, 'preguntas1' => $preguntas1, 'preguntas2' => $preguntas2, 'textoSalida1' => $textoSalida1, 'textoSalida2' => $textoSalida2]);
    }
    public function index_admin_user($id)
    {
        $citas = Cita::getCitasByUsuario($id);
        $user = User::find($id);
        $titulo = "Usuario: " . $user->name;
        return view('admin::citas.index', ['citas' => $citas, 'id' => $id, 'titulo' => $titulo]);
    }
    public function usuario()
    {
        //$citas = Cita::all();
        $user = auth()->user();
        return view('web.home.usuario', ['user' => $user]);
    }
    public function servicios()
    {
        $user = auth()->user();
        $servicios = Servicio::with(['usuario.client', 'tipoServicio'])->where('id_usuario', $user->id)->get();
        return view('web.home.servicios', ['user' => $user, 'servicios' => $servicios]);
    }

    public function serviciosPorPropiedad($id)
    {
        $tipoServicio = ServiciosTipo::all();
        $user = auth()->user();
        $servicios = Servicio::with(['usuario.client', 'tipoServicio'])->where('id_usuario', $user->id)->where('id_propiedad', $id)->get();
        return view('web.home.servicios', ['user' => $user, 'servicios' => $servicios, 'tipoServicio' => $tipoServicio, 'idPropiedad' => $id]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'usuario_id' => 'required|integer',
            'id_propiedad' => 'required|integer',
            'fecha_de_cita' => 'required|date|after_or_equal:today',
            'hora_de_cita' => 'required|date_format:H:i'
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Obtener la fecha actual y agregar un día
        $fechaActual = Carbon::now();
        $fechaLimite = $fechaActual->addDay()->startOfDay(); // Asegura que sea a partir de mañana

        // Verificar si la fecha_de_cita es al menos un día después de la fecha actual
        if (Carbon::parse($request->fecha_de_cita)->isBefore($fechaLimite)) {
            return redirect()->back()->with('error', 'La fecha de la cita debe ser al menos un día después de hoy.');
        }

        // Verificar si ya existe una cita para la misma fecha y hora
        $existeCita = Cita::where('fecha_de_cita', $request->fecha_de_cita)

            ->where('usuario_id', $request->usuario_id)
            ->exists();

        // Si existe una cita, retornar con un error
        if ($existeCita) {
            return redirect()->back()->with('error', 'Ya existe una cita para esta fecha y hora. Intenta con otra.');
        }

        Cita::create($request->all());
        return redirect()->route('propiedades.detalle', $request->id_propiedad)
            ->with('success', 'Cita guardada exitosamente.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        $cita = Cita::with(['propiedad', 'user.client'])->findOrFail($id);
        return view('admin::citas.edit', ['cita' => $cita, 'id' => $id]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_usuario' => 'sometimes|integer',
            'id_propiedad' => 'sometimes|integer',
            'fecha_de_cita' => 'sometimes|date',
            'hora_de_cita' => 'sometimes',
            'anotaciones' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $cita = Cita::findOrFail($request->id);
        $cita->update($request->all());

        return redirect()->route('citas.index', $request->id)->with('success', 'Servicio actualizado exitosamente.');
    }
    public function update_admin(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'fecha_de_cita' => 'sometimes|date',
            'hora_de_cita' => 'sometimes',
            'anotaciones' => 'nullable|string',
            'estado' => 'sometimes',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $cita = Cita::findOrFail($id);
        $cita->update($request->all());

        return redirect()->route('adm.citas.edit', $request->id)->with('success', 'Cita actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function generateTimes($anio, $mes, $dia)
    {
        $times = [];
        $startTimes = ['08:00', '14:00'];
        $endTimes = ['11:30', '18:00'];

        // Convertimos la fecha correctamente
        $fecha_original = sprintf('%04d-%02d-%02d', $anio, $mes, $dia);
        $date = new DateTime($fecha_original);
        $sFecha = $date->format('Y-m-d');

        foreach ($startTimes as $index => $startTime) {
            $start = new DateTime($startTime);
            $end = new DateTime($endTimes[$index]);

            while ($start <= $end) {
                $sHora = $start->format('H:i');
                // Validamos que no haya cita en esta hora
                $control = Cita::controlHora($sFecha, $sHora);
                // Validamos que no sea una hora pasada si es el día actual
                $horaActual = new DateTime();
                $horaCita = new DateTime($sHora);
                $control2 = true;
                /*if ($anio == date('Y') && $mes == date('m') && (int)$dia == (int)date('d')) {
                    if ($horaCita <= $horaActual) {
                        $control2 = false;
                    }
                }*/
                // Solo agregamos si no hay cita y la hora es válida
                if (empty($control) && $control2) {
                    $times[] = $sHora;
                }

                // Avanzamos 45 minutos
                $start->modify('+45 minutes');
            }
        }
        return $times;
    }

    private function ultimosMeses($n = 5, $txt = false, $adel = false)
    {
        // Obtener la fecha actual
        $fechaActual = new DateTime();
        // Crear un array para almacenar los meses
        $meses = [];
        // Iterar 5 veces hacia atrás
        for ($i = 0; $i < $n; $i++) {
            // Formatear la fecha como "AAAA-MM" y agregarla al array
            $meses[] = $mesesAux = $fechaActual->format('Y-m');
            //
            list($Anio, $Mes) = explode('-', $mesesAux);
            $mesesTxt[$mesesAux] = $Anio . '/' . $this->nombreMes($Mes);
            // Restar un mes a la fecha actual
            if ($adel) {
                $fechaActual->modify('+1 month');
            } else {
                $fechaActual->modify('-1 month');
            }
        }
        if ($txt) {
            if ($adel) {
                return $mesesTxt;
            }
            return array_reverse($mesesTxt);
        }
        return array_reverse($meses);
    }

    private function nombreMes($numeroMes)
    {
        // Array asociativo con los nombres de los meses
        $meses = [
            '01' => 'Enero',
            '02' => 'Febrero',
            '03' => 'Marzo',
            '04' => 'Abril',
            '05' => 'Mayo',
            '06' => 'Junio',
            '07' => 'Julio',
            '08' => 'Agosto',
            '09' => 'Septiembre',
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre'
        ];

        // Verificar si el número de mes es válido y existe en el array
        if (isset($meses[$numeroMes])) {
            return $meses[$numeroMes];
        } else {
            return "Mes inválido";
        }
    }
}
