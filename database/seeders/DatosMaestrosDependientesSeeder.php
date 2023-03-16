<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\Arr;

class DatosMaestrosDependientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('mae_sucursales_pilas')->delete();
        DB::table('mae_cuenta_bancarias')->delete();
        DB::table('mae_comunicaciones')->delete();
        DB::table('mae_configuracion_correos')->delete();
        DB::table('mae_configuracion_clientes')->delete();
        DB::table('mae_empresa_pilas')->delete();
        DB::table('mae_modalidad_servicios')->delete();
        DB::table('mae_terceros')->delete();

        var_dump("Registro de Terceros");
        $archivoCargadoFILE = json_decode($this->tercero());
        foreach ($archivoCargadoFILE as $archivoCargado) {
            $dv = null;
            if ($archivoCargado->DV != 'NULL')
                $dv = trim($archivoCargado->DV);

            $representante_cedula = null;
            if ($archivoCargado->REPRESENTANTELEGAL_CEDULA != 'NULL')
                $representante_cedula = trim($archivoCargado->REPRESENTANTELEGAL_CEDULA);

            $representante_nombre = null;
            if ($archivoCargado->REPRESENTANTELEGAL_NOMBRE != 'NULL')
                $representante_nombre = trim($archivoCargado->REPRESENTANTELEGAL_NOMBRE);

            $tipoActividad = null;
            if ($archivoCargado->TIPOACTIVIDAD != 'NULL')
                $tipoActividad = $archivoCargado->TIPOACTIVIDAD;

            $tipoRegimen = null;
            if ($archivoCargado->TIPOREGIMEN != 'NULL')
                $tipoRegimen = $archivoCargado->TIPOREGIMEN;

            $ciudad = null;
            if ($archivoCargado->CIUDAD != 'NULL')
                $ciudad = $archivoCargado->CIUDAD;

            $direccion = null;
            if ($archivoCargado->DIRECCION != 'NULL' && $archivoCargado->DIRECCION != '')
                $direccion = trim($$archivoCargado->DIRECCION);

            $contacto = null;
            if ($archivoCargado->CONTACTO != 'NULL' && $archivoCargado->CONTACTO != '')
                $contacto = trim($archivoCargado->CONTACTO);

            $codigoACH = null;
            if ($archivoCargado->CODIGOACH != 'NULL')
                $codigoACH = trim($archivoCargado->CODIGOACH);

            $otroACH = null;
            if ($archivoCargado->OTROACH != 'NULL')
                $otroACH = trim($archivoCargado->OTROACH);

            $archivoBancario = null;
            if ($archivoCargado->ARCHIVOBANCARIO != 'NULL')
                $archivoBancario = trim($archivoCargado->ARCHIVOBANCARIO);

            $tipoAportante = null;
            if ($archivoCargado->TIPOAPORTANTE != 'NULL') {
                $maeTipoAportantes = \App\Models\MaeTipoAportante::all();
                foreach ($maeTipoAportantes as $maeTipoAportante) {
                    if ($archivoCargado->TIPOAPORTANTE === $maeTipoAportante->tipoaportante)
                        $tipoAportante = $maeTipoAportante->id;
                }
            }

            $formaPresentacion = null;
            if ($archivoCargado->FORMAPRESENTACION != 'NULL')
                $formaPresentacion = $archivoCargado->FORMAPRESENTACION;

            $codigoSucursal = null;
            if ($archivoCargado->CODIGOSUCURSAL != 'NULL')
                $codigoSucursal = trim($archivoCargado->CODIGOSUCURSAL);

            $nombreSucursal = null;
            if ($archivoCargado->NOMBRESUCURSAL != 'NULL')
                $nombreSucursal = trim($archivoCargado->NOMBRESUCURSAL);

            $tipoplanilla = null;
            if ($archivoCargado->TIPOPLANILLA != 'NULL')
                $tipoplanilla = $archivoCargado->TIPOPLANILLA;

            $exceptionPila = null;
            if ($archivoCargado->EXCEPCION != 'NULL')
                $exceptionPila = $archivoCargado->EXCEPCION;

            $segundoCodigo = null;
            if ($archivoCargado->SEGUNDOCODIGO != 'NULL')
                $segundoCodigo = trim($archivoCargado->SEGUNDOCODIGO);


            \App\Models\MaeTercero::create([
                'tipopersona' => trim($archivoCargado->TIPOPERSONA),
                'tipoidentificacion' => trim($archivoCargado->TIPOIDENTIFICACION),
                'identificacion' => trim($archivoCargado->IDENTIFICACION),
                'dv' => $dv,
                'nombre' => trim($archivoCargado->NOMBRE),
                'sigla' => trim($archivoCargado->SIGLA),
                'representantelegal_cedula' => $representante_cedula,
                'representantelegal_nombre' => $representante_nombre,
                'tipoactividad' => $tipoActividad,
                'tiporegimen' => $tipoRegimen,
                'escliente' => trim($archivoCargado->ESCLIENTE),
                'esproveedor' => trim($archivoCargado->ESPROVEEDOR),
                'esbanco' => trim($archivoCargado->ESBANCO),
                'esempresapila' => trim($archivoCargado->ESEMPRESAPILA),
                'esempleado' => trim($archivoCargado->ESEMPLEADO),
                'esotros' => trim($archivoCargado->ESOTROS),
                'autoretenedor' => trim($archivoCargado->AUTORETENEDOR),
                'extranjero' => trim($archivoCargado->EXTRANJERO),
                'idciudad' => $ciudad,
                'direccion' => $direccion,
                'contacto' => $contacto,
                'codigoach' => $codigoACH,
                'otroach' => $otroACH,
                'archivobancario' => $archivoBancario,
                'servicionomina' => $archivoCargado->SERVICIONOMINA,
                // 'idarp' => trim($archivoCargado->CODIGOBANCO),
                'idtipoaportante' => $tipoAportante,
                'formapresentacion' => $formaPresentacion,
                'codigosucursal' => $codigoSucursal,
                'nombresucursal' => $nombreSucursal,
                'tipoplanilla' => $tipoplanilla,
                'excepcionpila' => $exceptionPila,
                'segundocodigo' => $segundoCodigo,
                'activo' => $archivoCargado->ACTIVO
            ]);
        }

        var_dump("Registro Modalidad de Servicios");
        $archivoCargadoFILE = json_decode($this->modalidad());
        foreach ($archivoCargadoFILE as $archivoCargado) {
            foreach (\App\Models\MaeTercero::where('identificacion', $archivoCargado->IDCLIENTE)->cursor() as $maeTercero) {
                \App\Models\MaeModalidadServicio::create([
                    'idcliente' => $maeTercero->id,
                    'modalidadservicio' => trim($archivoCargado->MODALIDADSERVICIO),
                    'tipomodalidad' => trim($archivoCargado->TIPOMODALIDAD),
                    'especificar' => trim($archivoCargado->ESPECIFICAR),
                    'salariomlv' => trim($archivoCargado->SALARIOMLV),
                    'subtransporte' => trim($archivoCargado->SUBTRANSPORTE),
                    'incp_general' => trim($archivoCargado->INCP_GENERAL),
                    'incp_arp' => trim($archivoCargado->INCP_ARP),
                    'verdias' => trim($archivoCargado->VERDIAS),
                    'p_subtransporte' => trim($archivoCargado->P_SUBTRANSPORTE),
                    'prov_mensuales' => trim($archivoCargado->PROV_MENSUALES),
                    'activo' => trim($archivoCargado->ACTIVO)
                ]);
            }
        }

        var_dump("Registros Empresas PILA");
        $archivoCargadoFILE = json_decode($this->empresa_pila());
        foreach ($archivoCargadoFILE as $archivoCargado) {
            foreach (\App\Models\MaeTercero::where('identificacion', $archivoCargado->IDTERCERO)->cursor() as $maeTercero) {
                \App\Models\MaeEmpresaPila::create([
                    'idtercero' => $maeTercero->id,
                    'codigo' => trim($archivoCargado->CODIGO),
                    'tiposervicio' => trim($archivoCargado->TIPOSERVICIO)
                ]);
            }
        }

        var_dump("Registros Configuracion de Clientes");
        $archivoCargadoFILE = json_decode($this->configuracion_cliente());
        foreach ($archivoCargadoFILE as $archivoCargado) {
            foreach (\App\Models\MaeTercero::where('identificacion', $archivoCargado->IDTERCERO)->cursor() as $maeTercero) {
                \App\Models\MaeConfiguracionCliente::create([
                    'idtercero' => $maeTercero->id,
                    'ano' => trim($archivoCargado->ANO),
                    'fecharegistro' => date('Y-m-d H:i:s', strtotime($archivoCargado->FECHAREGISTRO)),
                    'salariomlv' => trim($archivoCargado->SALARIOMLV),
                    'subtransporte' => trim($archivoCargado->SUBTRANSPORTE),
                    'incp_general' => trim($archivoCargado->INCP_GENERAL),
                    'incp_arp' => trim($archivoCargado->INCP_ARP),
                    'uvt' => trim($archivoCargado->UVT),
                    'verdias' => trim($archivoCargado->VERDIAS),
                    'p_subtransporte' => trim($archivoCargado->P_SUBTRANSPORTE),
                    'prov_mensuales' => trim($archivoCargado->PROV_MENSUALES),
                    'volante_pago' => trim($archivoCargado->VOLANTE_PAGO),
                    'volante_pago_logo' => trim($archivoCargado->VOLANTE_PAGO_LOGO)
                ]);
            }
        }

        var_dump("Registros Configuracion de Correos");
        $archivoCargadoFILE = json_decode($this->configuracion_correos());
        foreach ($archivoCargadoFILE as $archivoCargado) {
            foreach (\App\Models\MaeTercero::where('identificacion', $archivoCargado->IDTERCERO)->cursor() as $maeTercero) {
                \App\Models\MaeConfiguracionCorreo::create([
                    'idtercero' => $maeTercero->id,
                    'correo' => trim($archivoCargado->CORREO),
                    'clave' => trim($archivoCargado->CLAVE),
                    'host' => trim($archivoCargado->HOST),
                    'puerto' => trim($archivoCargado->PUERTO),
                    'soporta_ssl' => trim($archivoCargado->SOPORTA_SSL)
                ]);
            }
        }

        var_dump("Registros Comunicacion de Terceros");
        $archivoCargadoFILE = json_decode($this->telefono_comunicaciones());
        foreach ($archivoCargadoFILE as $archivoCargado) {
            foreach (\App\Models\MaeTercero::where('identificacion', $archivoCargado->IDTERCERO)->cursor() as $maeTercero) {
                \App\Models\MaeComunicacion::create([
                    'idtercero' => $maeTercero->id,
                    'tipo' => trim($archivoCargado->TIPO),
                    'concepto' => trim($archivoCargado->CONCEPTO)
                ]);
            }
        }

        var_dump("Registros Cuentas Bancarias");
        $archivoCargadoFILE = json_decode($this->cuenta_bancarria());
        foreach ($archivoCargadoFILE as $archivoCargado) {
            foreach (\App\Models\MaeTercero::where('identificacion', $archivoCargado->IDTERCERO)->cursor() as $maeTercero) {
                foreach (\App\Models\MaeTercero::where('identificacion', $archivoCargado->IDBANCO)->cursor() as $maeBanco) {
                    \App\Models\MaeCuentaBancaria::create([
                        'idtercero' => $maeTercero->id,
                        'idbanco' => $maeBanco->id,
                        'cuentabancaria' => trim($archivoCargado->CUENTABANCARIA),
                        'tipocuenta' => trim($archivoCargado->TIPOCUENTA),
                        'cuentacontable' => trim($archivoCargado->CUENTACONTABLE),
                        'transferenciabancaria' => trim($archivoCargado->TRANSFERENCIABANCARIA),
                        'planillaunica' => trim($archivoCargado->PLANILLAUNICA),
                        'activo' => trim($archivoCargado->ACTIVO)
                    ]);
                }
            }
        }

        var_dump("Registros Sucursal PILA");
        $archivoCargadoFILE = json_decode($this->sucursal_pila());
        foreach ($archivoCargadoFILE as $archivoCargado) {
            foreach (\App\Models\MaeTercero::where('identificacion', $archivoCargado->IDCLIENTE)->cursor() as $maeTercero) {
                \App\Models\MaeSucursalesPila::create([
                    'idcliente' => $maeTercero->id,
                    'codigo' => trim($archivoCargado->CODIGO),
                    'sucursalpila' => trim($archivoCargado->SUCURSALPILA),
                    'activo' => trim($archivoCargado->ACTIVO)
                ]);
            }
        }

        var_dump("Registros Conceptos de Novedad por Empresas");
        DB::table('mae_asignaciones_contables')->delete();
        DB::table('mae_concepto_novedad_empresas')->delete();
        $archivoCargadoFILE = json_decode($this->concepto_novedad_empresa());
        $asignacionContableFILE = json_decode($this->asignacion_contable());
        foreach ($archivoCargadoFILE as $archivoCargado) {
            $idconcepto = null;
            $calculo = null;
            if ($archivoCargado->TIPO === "1") {
                if ($archivoCargado->CALCULO != "NULL" && $archivoCargado->CALCULO != "" && $archivoCargado->CALCULO != null) {
                    //Analizando la formula y actualizando los ID para los calculos
                    $calculo = $archivoCargado->CALCULO;
                    $separada = $this->multiexplode(array("[", "]"), $calculo);
                    //var_dump($separada);
                    foreach ($separada as $cadena) {
                        if (is_numeric($cadena)) {
                            $contentFilter = current(array_filter($archivoCargadoFILE, function ($item) use ($cadena) {
                                return $item->Id === $cadena;
                            }));
                            //var_dump($contentFilter);
                            if ($contentFilter != null && $contentFilter != "") {
                                if ($contentFilter->IDCONCEPTO != "" && $contentFilter->IDCONCEPTO != "NULL") {
                                    $calculo =  str_replace("[" . trim($cadena) . "]", "[" . trim($contentFilter->IDCONCEPTO) . "]", $calculo);
                                } else {
                                    $calculo =  str_replace("[" . trim($cadena) . "]", "[NO SE ENCONTRO]", $calculo);
                                }
                            } else {
                                $calculo =  str_replace("[" . trim($cadena) . "]", "[NO SE ENCONTRO]", $calculo);
                            }
                        }
                    }
                }

                foreach (\App\Models\MaeConceptoNovedad::where('conceptonovedad', $archivoCargado->CONCEPTO)->cursor() as $maeConceptoNovedad) {
                    $idconcepto = $maeConceptoNovedad->id;
                }
            } else {
                foreach (\App\Models\MaeEmpresaPila::where('codigo', $archivoCargado->CONCEPTO)->cursor() as $maeEmpresaPila) {
                    $idconcepto = $maeEmpresaPila->id;
                }
            }
            $codAuxiliar = null;
            if ($archivoCargado->CODAUXILIAR != null && $archivoCargado->CODAUXILIAR != "NULL")
                $codAuxiliar =  $archivoCargado->CODAUXILIAR;

            if ($idconcepto != null) {
                $maeCoceptoEmpresa = \App\Models\MaeConceptoNovedadEmpresa::create([
                    'idconcepto' => $idconcepto,
                    'idmodalidadservicio' => trim($archivoCargado->IDMODALIDADSERVICIO),
                    'aplicacion' => trim($archivoCargado->APLICACION),
                    'calculo' => $calculo,
                    'tipo' => trim($archivoCargado->TIPO),
                    'especificar' => trim($archivoCargado->ESPECIFICAR),
                    'codauxiliar' => $codAuxiliar,
                    'activo' => trim($archivoCargado->ACTIVO)
                ]);
                $archivoCargado->IDCONCEPTO = $maeCoceptoEmpresa->id;

                //Registristrnado otros datos maestros
                if ($archivoCargado->TIPO === "1") {
                    $id_conceptoEmpresa = $archivoCargado->Id;
                    $contentFiltrosAC = array_filter($asignacionContableFILE, function ($item) use ($id_conceptoEmpresa) {
                        return $item->IDCONCEPTONOVEDADEMPRESA === $id_conceptoEmpresa;
                    });
                    if ($contentFiltrosAC != null && $contentFiltrosAC != "") {
                        // var_dump($contentFiltrosAC);
                        foreach ($contentFiltrosAC as $contentFiltro) {
                            $debito = null;
                            if ($contentFiltro->DEBITO != 'NULL' && $contentFiltro->DEBITO != "")
                                $debito = trim($contentFiltro->DEBITO);
                            $credito = null;
                            if ($contentFiltro->CREDITO != 'NULL' && $contentFiltro->CREDITO != "")
                                $credito = trim($contentFiltro->CREDITO);
                            $incapacidad = null;
                            if ($contentFiltro->INCAPACIDAD != 'NULL' && $contentFiltro->INCAPACIDAD != "")
                                $incapacidad = trim($contentFiltro->INCAPACIDAD);
                            // var_dump($credito);
                            // var_dump($incapacidad);
                            foreach (\App\Models\MaeRubroContable::where('rubrocontable', $contentFiltro->RUBROCONTABLE)->cursor() as $maeRubroContable) {
                                \App\Models\MaeAsignacionesContable::create([
                                    'idconceptonovedadempresa' => $maeCoceptoEmpresa->id,
                                    'idrubrocontable' => $maeRubroContable->id,
                                    'ccdebito' => $contentFiltro->CCDEBITO,
                                    'cadebito' => $contentFiltro->CADEBITO,
                                    'debito' => $debito,
                                    'cccredito' => $contentFiltro->CCCREDITO,
                                    'cacredito' => $contentFiltro->CACREDITO,
                                    'credito' => $credito,
                                    'incapacidad' => $incapacidad,
                                    'tipo' => trim($contentFiltro->TIPO)
                                ]);
                            }
                        }
                    }
                }
            }
        }
    }

    function multiexplode($delimiters, $string)
    {

        $ready = str_replace($delimiters, $delimiters[0], $string);
        $launch = explode($delimiters[0], $ready);
        return  $launch;
    }
    public function tercero()
    {
        return '[
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"860002534","DV":"1","NOMBRE":"ASEGURADORA DE VIDA COLSEGUROS","SIGLA":"COLSEGUROS","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"860002528","DV":"6","NOMBRE":"COMPAÑIA AGRICOLA DE SEGUROS DE VIDA SA","SIGLA":"COMPAÑIA AGRICOLA DE SEGUROS DE VIDA SA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"860002503","DV":"2","NOMBRE":"CIA DE SEGUROS BOLIVAR SA","SIGLA":"SEGUROS BOLIVAR SA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"890300465","DV":"2","NOMBRE":"COMPAÑIA DE SEGUROS DE VIDA AURORA","SIGLA":"SEGUROS VIDA AURORA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"800228175","DV":"2","NOMBRE":"RIESGOS PROFESIONALES COLMENA SA COMPAÑIA DE SEGUROS DE VIDA","SIGLA":"COLMENA SA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"860002183","DV":"9","NOMBRE":"SEGUROS DE VIDA COLPATRIA SA","SIGLA":"COLPATRIA SA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"800226098","DV":"4","NOMBRE":"BBVA SEGUROS DE VIDA COLOMBIA SA","SIGLA":"SEGUROS DE VIDA COLOMBIA SA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"890903790","DV":"9","NOMBRE":"COMPAÑIA SURAMERICANA ADMINISTRADORA DE RIESGOS PROFESIONALES Y SEGUROS VIDA","SIGLA":"SURAMERICANA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"860011153","DV":"6","NOMBRE":"LA PREVISORA VIDA SA COMPAÑIA DE SEGUROS","SIGLA":"LA PREVISORA VIDA SA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"860503617","DV":"3","NOMBRE":"SEGUROS DE VIDA ALFA SA","SIGLA":"SEGUROS DE VIDA ALFA SA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"860006578","DV":"6","NOMBRE":"SEGUROS DE VIDA DEL ESTADO SA","SIGLA":"SEGUROS DE VIDA DEL ESTADO SA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"860008645","DV":"0","NOMBRE":"LIBERTY SEGUROS DE VIDA","SIGLA":"LIBERTY","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"860028415","DV":"5","NOMBRE":"LA EQUIDAD SEGUROS DE VIDA ORGANISMO COOPERATIVO - LA EQUIDAD VIDA","SIGLA":"LA EQUIDAD VIDA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"830005997","DV":"1","NOMBRE":"COMPAÑIA CENTRAL DE SEGUROS DE VIDA SA","SIGLA":"CENTRAL DE SEGUROS DE VIDA SA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"860013816","DV":"1","NOMBRE":"INSTITUTO DE SEGUROS SOCIALES ISS RIESGOS PROFESIONALES","SIGLA":"ISS","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"800229739","DV":"1","NOMBRE":"ADMINISTRADORA DE FONDOS DE PENSIONES Y CESANTIA PROTECCION SA","SIGLA":"PROTECCION SA.","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"800224808","DV":"3","NOMBRE":"SOCIEDAD ADMINISTRADORA DE FONDOS DE PENSIONES Y CESANTIAS PORVENIR SA","SIGLA":"PORVENIR SA.","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"800231967","DV":"1","NOMBRE":"BBVA HORIZONTE SOCIEDAD ADMINISTRADORA DE FONDOS DE PENSIONES Y DE CESANTIAS SA","SIGLA":"HORIZONTE SA.","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"800148959","DV":"6","NOMBRE":"FONDOS DE PENSIONES Y CESANTIA SANTANDER SA","SIGLA":"SANTANDER SA.","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"800253055","DV":"2","NOMBRE":"SKANDIA ADMINISTRADORA DE FONDOS DE PENSIONES Y CESANTIAS SA","SIGLA":"SKANDIA SA.","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"800227940","DV":"2","NOMBRE":"COMPAÑIA COLOMBIANA ADMINISTRADORA DE FONDOS DE PENSIONES Y CESANTIAS SA COLFONDOS","SIGLA":"COLFONDOS SA.","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"860007379","DV":"8","NOMBRE":"CAJA DE AUXILIOS Y PRESTACIONES DE LA ASOCIACION COLOMBIANA DE AVIADORES CIVILES ACDAC ÑCAXDAC\"","SIGLA":"CAXDAC","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"899999734","DV":"7","NOMBRE":"FONDO DE PREVISION SOCIAL DEL CONGRESO DE LA REPUBLICA ÑFONPRECON-","SIGLA":"FONPRECON","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"899999026","DV":"0","NOMBRE":"CAJA DE PREVISION SOCIAL DE COMUNICACIONES -CAPRECOM-","SIGLA":"CAPRECOM","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"800216278","DV":"0","NOMBRE":"PENSIONES DE ANTIOQUIA","SIGLA":"PENSIONES DE ANTIOQUIA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"899999010","DV":"3","NOMBRE":"CAJA NACIONAL DE PREVISION SOCIAL ÑCAJANALÑ","SIGLA":"CAJANAL","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"860007336","DV":"1","NOMBRE":"CAJA COLOMBIANA DE SUBSIDIO FAMILIAR COLSUBSIDIO","SIGLA":"COLSUBSIDIO","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"860007331","DV":"5","NOMBRE":"CAJA DE COMPENSACION FAMILIAR AFIDRO","SIGLA":"AFIDRO","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"860013433","DV":"2","NOMBRE":"CAJA DE COMPENSACION FAMILIAR ASFAMILIAS","SIGLA":"ASFAMILIAS","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"860013570","DV":"3","NOMBRE":"CAJA DE COMPENSACION FAMILIAR CAFAM","SIGLA":"CAFAM","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"890102044","DV":"1","NOMBRE":"CAJA DE COMPENSACION FAMILIAR CAJACOPI ATLANTICO","SIGLA":"CAJACOPI - ATLANTICO","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"890900840","DV":"1","NOMBRE":"CAJA DE COMPENSACION FAMILIAR CAMACOL COMFAMILIAR CAMACOL","SIGLA":"COMFAMILIAR - CAMACOL","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"800231969","DV":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR CAMPESINA COMCAJA","SIGLA":"CAMPESINA COMCAJA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"890101994","DV":"9","NOMBRE":"CAJA DE COMPENSACION FAMILIAR COMFAMILIAR DEL ATLANTICO","SIGLA":"COMFAMILIAR - ATLANTICO","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"891380056","DV":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR COMFAMILIARES UNIDAS DEL VALLE COMFAUNION","SIGLA":"COMFAUNION - UNIDAS DEL VALLE","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"890600842","DV":"6","NOMBRE":"CAJA DE COMPENSACION FAMILIAR COMFENALCO ANTIOQUIA","SIGLA":"COMFENALCO - ANTIOQUIA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"890303093","DV":"5","NOMBRE":"CAJA DE COMPENSACION FAMILIAR COMFENALCO DEL VALLE DEL CAUCA - COMFENALCO VALLE","SIGLA":"COMFENALCO - VALLE","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"890201578","DV":"7","NOMBRE":"CAJA DE COMPENSACION FAMILIAR COMFENALCO SANTANDER","SIGLA":"COMFENALCO - SANTANDER","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"860066942","DV":"7","NOMBRE":"CAJA DE COMPENSACION FAMILIAR COMPENSAR","SIGLA":"COMPENSAR","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"890900841","DV":"9","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DE ANTIOQUIA COMFAMA","SIGLA":"COMFAMA - ANTIOQUIA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"800219488","DV":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DE ARAUCA COMFIAR","SIGLA":"COMFIAR - ARAUCA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"890270275","DV":"5","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DE BARRANCABERMEJA CAFABA","SIGLA":"CAFABA - BARRANCABERMEJA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"890102002","DV":"2","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DE BARRANQUILLA COMBARRANQUILLA","SIGLA":"COMBARRANQUILLA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"891800213","DV":"8","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DE BOYACA - COMFABOY","SIGLA":"COMFABOY - BOYACA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"890304033","DV":"8","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DE BUENAVENTURA","SIGLA":"COMFAMILIAR - BUENAVENTURA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"890480110","DV":"1","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DE CARTAGENA","SIGLA":"COMFAMILIAR - CARTAGENA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"891900452","DV":"0","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DE CARTAGO - COMFACARTAGO","SIGLA":"COMFACARTAGO","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"891080005","DV":"1","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DE CORDOBA COMFACOR","SIGLA":"COMFACOR - CORDOBA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"860045904","DV":"7","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DE CUNDINAMARCA - COMFACUNDI","SIGLA":"COMFACUMDI - CUNDINAMARCA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"890480023","DV":"7","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DE FENALCO - ANDI COMFENALCO CARTAGENA","SIGLA":"COMFENALCO CARTAGENA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"860006606","DV":"0","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DE FENALCO COMFENALCO CUNDINAMARCA","SIGLA":"COMFENALCO - CUNDINAMARCA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"890000381","DV":"0","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DE FENALCO COMFENALCO QUINDIO","SIGLA":"COMFENALCO - QUINDIO","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"890700148","DV":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DE FENALCO DEL TOLIMA - COMFENALCO","SIGLA":"COMFENALCO - TOLIMA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"890680023","DV":"5","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DE GIRARDOT COMGIRARDOT (EN LIQUIDACION)","SIGLA":"COMGIRARDOT","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"890700679","DV":"3","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DE HONDA COMFAHONDA","SIGLA":"COMFAHONDA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"892115006","DV":"5","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DE LA GUAJIRA","SIGLA":"COMFAMILIAR - LA GUAJIRA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"891200208","DV":"6","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DE NARIÑO","SIGLA":"COMFAMILIAR - NARIÑO","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"891480000","DV":"1","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DE RISARALDA- COMFAMILIAR RISARALDA","SIGLA":"COMFAMILIAR - RISARALDA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"892400320","DV":"5","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DE SAN ANDRES Y PROVIDENCIA, ISLAS CAJASAI","SIGLA":"ISLAS CAJASAI","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"892200015","DV":"5","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DE SUCRE","SIGLA":"COMFAMILIAR - SUCRE","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"891900280","DV":"0","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DE TULUA - COMFAMILIAR DE TULUA","SIGLA":"COMFAMILIAR - TULUA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"800003122","DV":"6","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DEL AMAZONAS CAFAMAZ","SIGLA":"CAFAMAZ - AMAZONAS","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"891190047","DV":"2","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DEL CAQUETA - COMFACA","SIGLA":"COMFACA - CAQUETA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"844003392","DV":"8","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DEL CASANARE - COMFACASANARE","SIGLA":"COMFACASANARE","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"891500182","DV":"0","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DEL CAUCA - COMFACAUCA","SIGLA":"COMFACAUCA - CAUCA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"892399989","DV":"8","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DEL CESAR COMFACESAR","SIGLA":"COMFESAR - CESAR","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"891600091","DV":"8","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DEL CHOCO","SIGLA":"COMFAMILIAR - CHOCO","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"891180008","DV":"2","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DEL HUILA - COMFAMILIAR","SIGLA":"COMFAMILIAR - HUILA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"891780093","DV":"3","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DEL MAGDALENA","SIGLA":"COMFAMILIAR - MAGDALENA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"890500516","DV":"3","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DEL NORTE DE SANTANDER COMFANORTE","SIGLA":"COMFANORTE - NORTE SANTANDER","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"890500675","DV":"6","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DEL ORIENTE COLOMBIANO COMFAORIENTE","SIGLA":"COMFAORIENTE - ORIENTE COLOMBIANO","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"891200337","DV":"8","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DEL PUTUMAYO - COMFAMILIAR PUTUMAYO","SIGLA":"COMFAMILIAR - PUTUMAYO","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"890000062","DV":"6","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DEL QUINDIO COMFAMILIAR","SIGLA":"COMFAMILIAR - QUINDIO","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"890704737","DV":"7","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DEL SUR DEL TOLIMA CAFASUR","SIGLA":"CAFASUR - TOLIMA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"890700687","DV":"2","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DEL TOLIMA COMFATOLIMA","SIGLA":"COMFATOLIMA - TOLIMA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"890303208","DV":"5","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DEL VALLE DEL CAUCA COMFAMILIAR ANDI - COMFANDI","SIGLA":"COMFANDI - VALLE DEL CAUCA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"892000146","DV":"3","NOMBRE":"CAJA DE COMPENSACION FAMILIAR REGIONAL DEL META COFREM","SIGLA":"COFREM - REGIONAL DEL META","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"890200106","DV":"1","NOMBRE":"CAJA SANTANDEREANA DE SUBSIDIO FAMILIAR CAJASAN","SIGLA":"CAJASAN","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"0"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"899999034","DV":"1","NOMBRE":"SENA","SIGLA":"SENA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"899999239","DV":"2","NOMBRE":"INSTITUTO COLOMBIANO DE BIENESTAR FAMILIAR","SIGLA":"ICBF","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"899999001","DV":"7","NOMBRE":"MINISTERIO DE EDUCACION","SIGLA":"MIN-EDUCACION","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"800106339","DV":"0","NOMBRE":"COLMEDICA EPS","SIGLA":"COLMEDICA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"800130907","DV":"4","NOMBRE":"SALUD TOTAL SA ENTIDAD PROMOTORA DE SALUD","SIGLA":"SALUD TOTAL","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"800140949","DV":"6","NOMBRE":"CAFESALUD MEDICINA PREPAGADA SA","SIGLA":"CAFESALUD","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"800251440","DV":"6","NOMBRE":"ENTIDAD PROMOTORA DE SALUD SANITAS SA","SIGLA":"SANITAS SA.","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"800088702","DV":"2","NOMBRE":"SUSALUD EPS","SIGLA":"SUSALUD EPS","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"800250119","DV":"1","NOMBRE":"ENTIDAD PROMOTORA DE SALUD ORGANISMO COOPERATIVO SALUDCOOP","SIGLA":"SALUDCOOP","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"830006404","DV":"0","NOMBRE":"HUMANA VIVIR SA  EPS  ARS","SIGLA":"HUMANA VIVIR","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"860512237","DV":"6","NOMBRE":"PROGRAMA SERVICIOS MEDICOS COLPATRIA SA ENTIDAD PROMOTORA DE SALUD","SIGLA":"SALUD COLPATRIA SA.","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"805000427","DV":"1","NOMBRE":"COOMEVA ENTIDAD PROMOTORA DE SALUD SA","SIGLA":"COOMEVA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"830003564","DV":"7","NOMBRE":"ENTIDAD PROMOTORA DE SALUD FAMISANAR LIMITADA CAFAM-COLSUBSIDIO","SIGLA":"FAMISANAR","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"805001157","DV":"2","NOMBRE":"ENTIDAD PROMOTORA DE SALUD SERVICIO OCCIDENTAL DE SALUD SA SOS","SIGLA":"SERVICIO OCCIDENTAL DE SALUD","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"830009783","DV":"0","NOMBRE":"CRUZ BLANCA ENTIDAD PROMOTORA DE SALUD SA","SIGLA":"CRUZ BLANCA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"891856000","DV":"0","NOMBRE":"CAPRESOCA EPS","SIGLA":"CAPRESOCA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"804001273","DV":"5","NOMBRE":"SOLSALUD EPS SA","SIGLA":"SOLSALUD","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"805004565","DV":"8","NOMBRE":"CALISALUD ENTIDAD PROMOTORA DE SALUD","SIGLA":"CALISALUD","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"814000608","DV":"0","NOMBRE":"ENTIDAD PROMOTORA DE SALUD CONDOR SA  -   EPS CONDOR SA","SIGLA":"CONDOR SA.","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"846000244","DV":"1","NOMBRE":"SELVASALUD SA ENTIDAD PROMOTORA DE SALUD SELVASALUD SA EPS","SIGLA":"SELVASALUD","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"830074184","DV":"5","NOMBRE":"SALUDVIDA SA ENTIDAD PROMOTORA DE SALUD","SIGLA":"SALUDVIDA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"805021984","DV":"2","NOMBRE":"SALUDCOLOMBIA ENTIDAD PROMOTORA DE SALUD SA","SIGLA":"SALUCCOLOMBIA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"830096513","DV":"1","NOMBRE":"RED SALUD ATENCION HUMANA EPS SA","SIGLA":"RED SALUD","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"890904996","DV":"1","NOMBRE":"EMPRESAS PUBLICAS DE MEDELLIN DEPARTAMENTO MEDICO","SIGLA":"EMPRESAS PUBLICAS DE MEDELLIN","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"800112806","DV":"2","NOMBRE":"FONDO DE PASIVO SOCIAL DE FERROCARRILES NACIONALES DE COLOMBIA","SIGLA":"FONDO PASIVO","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"860530751","DV":"7","NOMBRE":"BANCO DE BOGOTA","SIGLA":"BOGOTA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"1","CODIGOACH":"1001","OTROACH":"5600010","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"0","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"860007738","DV":"9","NOMBRE":"BANCO POPULAR","SIGLA":"POPULAR","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"1","CODIGOACH":"1002","OTROACH":"5600023","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"0","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"890903937","DV":"0","NOMBRE":"BANCO SANTANDER","SIGLA":"SANTANDER","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"1","CODIGOACH":"1006","OTROACH":"5600065","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"0","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"890903938","DV":"9","NOMBRE":"BANCOLOMBIA S.A.","SIGLA":"BANCOLOMBIA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"1","CODIGOACH":"1007","OTROACH":"5600078","ARCHIVOBANCARIO":"2","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"0","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"860051705","DV":"2","NOMBRE":"ABN AMRO BANK COLOMBIA S.A.","SIGLA":"ABN AMRO BANK","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"1","CODIGOACH":"1008","OTROACH":"5600081","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"0","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"860051135","DV":"4","NOMBRE":"CITIBANK S.A.","SIGLA":"CITIBANK","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"1","CODIGOACH":"1009","OTROACH":"5600094","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"0","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"860050930","DV":"9","NOMBRE":"BANISTMO S.A.","SIGLA":"BANISTMO","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"1","CODIGOACH":"1010","OTROACH":"1010","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"0","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"860050750","DV":"1","NOMBRE":"BANCO GNB SUDAMERIS","SIGLA":"SUDAMERIS","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"1","CODIGOACH":"1012","OTROACH":"5600120","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"0","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"860003020","DV":"1","NOMBRE":"BBVA COLOMBIA S.A.","SIGLA":"BBVA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"1","CODIGOACH":"1013","OTROACH":"5600133","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"0","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"860007660","DV":"3","NOMBRE":"BANCO DE CREDITO S.A.","SIGLA":"BANCO DE CREDITO","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"1","CODIGOACH":"1014","OTROACH":"5600146","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"0","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"860034594","DV":"1","NOMBRE":"BANCO COLPATRIA RED MULTIBANCA","SIGLA":"RED MULTIBANCA COLPATRIA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"1","CODIGOACH":"1019","OTROACH":"5600191","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"0","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"860050923","DV":"7","NOMBRE":"BANCO UNION COLOMBIANO","SIGLA":"BANCO UNION COLOMBIANO","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"1","CODIGOACH":"1022","OTROACH":"5600227","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"0","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"890300279","DV":"4","NOMBRE":"BANCO DE OCCIDENTE","SIGLA":"BANCO DE OCCIDENTE","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"1","CODIGOACH":"1023","OTROACH":"5600230","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"0","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"860007335","DV":"4","NOMBRE":"BCSC SOCIAL","SIGLA":"CAJA SOCIAL BCSC","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"1","CODIGOACH":"1032","OTROACH":"5600829","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"0","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"860034921","DV":"5","NOMBRE":"MEGABANCO S.A.","SIGLA":"MEGABANCO","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"1","CODIGOACH":"1036","OTROACH":"1036","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"0","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"900010939","DV":"8","NOMBRE":"GRANBANCO","SIGLA":"GRANBANCO","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"1","CODIGOACH":"1050","OTROACH":"5600052","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"0","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"860034313","DV":"7","NOMBRE":"BANCO DAVIVIENDA S.A.","SIGLA":"DAVIVIENDA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"1","CODIGOACH":"1051","OTROACH":"5895142","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"0","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"860035827","DV":"5","NOMBRE":"AV VILLAS","SIGLA":"AV VILLAS","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"1","CODIGOACH":"1052","OTROACH":"6013677","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"0","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"899999035","DV":"7","NOMBRE":"COLMENA BCSC","SIGLA":"COLMENA BCSC","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"1","CODIGOACH":"1057","OTROACH":"5701809","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"0","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"899999107","DV":"9","NOMBRE":"CONVIDA EPS","SIGLA":"CONVIDA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"810000678","DV":"8","NOMBRE":"DE CALDAS EPS","SIGLA":"DE CALDAS","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"830079672","DV":"0","NOMBRE":"FOSYGA","SIGLA":"FOSYGA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"900074992","DV":"3","NOMBRE":"GOLDEN GROUP","SIGLA":"GOLDEN GROUP","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"800140680","DV":"0","NOMBRE":"UNIMEC","SIGLA":"UNIMEC","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"900243504","DV":"8","NOMBRE":"FINANCIERA JURISCOOP","SIGLA":"JURISCOOP","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"","CONTACTO":"","ESBANCO":"1","CODIGOACH":"1296","OTROACH":"0","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"","NOMBRESUCURSAL":"","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"0","ESEMPLEADO":"0","SEGUNDOCODIGO":"NULL","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"888888888","DV":"9","NOMBRE":"SOFTDIN","SIGLA":"SOFTDIN","REPRESENTANTELEGAL_CEDULA":"88888888","REPRESENTANTELEGAL_NOMBRE":"DEIVI IBARRA NEGRETTE","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"1","ESPROVEEDOR":"0","ESOTROS":"0","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"NULL","CONTACTO":"NULL","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"1","TIPOAPORTANTE":"EMPLEADOR","FORMAPRESENTACION":"1","CODIGOSUCURSAL":"NULL","NOMBRESUCURSAL":"NULL","TIPOPLANILLA":"1","EXCEPCION":"1","ESEMPRESAPILA":"0","ESEMPLEADO":"0","SEGUNDOCODIGO":"","ACTIVO":"1"},
            {"TIPOPERSONA":"1","TIPOIDENTIFICACION":"1","IDENTIFICACION":"111","DV":"NULL","NOMBRE":"TRABAJADOR DE PRUEBA","SIGLA":"TRABAJADOR DE PRUEBA","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"NULL","CONTACTO":"NULL","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"NULL","NOMBRESUCURSAL":"NULL","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"0","ESEMPLEADO":"1","SEGUNDOCODIGO":"","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"900336004","DV":"7","NOMBRE":"ADMINISTRADORA COLOMBIANA DE PENSIONES COLPENSIONES","SIGLA":"COLPENSIONES","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"NULL","CONTACTO":"NULL","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"NULL","NOMBRESUCURSAL":"NULL","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"900156264","DV":"2","NOMBRE":"NUEVA EPS","SIGLA":"NUEVA EPS","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"NULL","CONTACTO":"NULL","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"NULL","NOMBRESUCURSAL":"NULL","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"800249241","DV":"0","NOMBRE":"COOSALUD","SIGLA":"COOSALUD","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"NULL","CONTACTO":"NULL","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"NULL","NOMBRESUCURSAL":"NULL","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"806008394","DV":"7","NOMBRE":"MUTUAL SER","SIGLA":"MUTUAL SER","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"NULL","CONTACTO":"NULL","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"NULL","NOMBRESUCURSAL":"NULL","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"","ACTIVO":"1"},
            {"TIPOPERSONA":"2","TIPOIDENTIFICACION":"6","IDENTIFICACION":"901097473","DV":"5","NOMBRE":"MEDIMAS","SIGLA":"MEDIMAS","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"NULL","CONTACTO":"NULL","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"NULL","NOMBRESUCURSAL":"NULL","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"1","ESEMPLEADO":"0","SEGUNDOCODIGO":"","ACTIVO":"1"},
            {"TIPOPERSONA":"1","TIPOIDENTIFICACION":"1","IDENTIFICACION":"99999999","DV":"NULL","NOMBRE":"DEIVI IBARRA NEGRETTE","SIGLA":"DEIVI IBARRA NEGRETTE","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"NULL","CONTACTO":"NULL","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"NULL","NOMBRESUCURSAL":"NULL","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"0","ESEMPLEADO":"1","SEGUNDOCODIGO":"","ACTIVO":"1"},
            {"TIPOPERSONA":"1","TIPOIDENTIFICACION":"1","IDENTIFICACION":"88888888","DV":"NULL","NOMBRE":"INGRID TERESA ROCHA MANJARREZ","SIGLA":"INGRID TERESA ROCHA MANJARREZ","REPRESENTANTELEGAL_CEDULA":"NULL","REPRESENTANTELEGAL_NOMBRE":"NULL","TIPOACTIVIDAD":"NULL","TIPOREGIMEN":"NULL","ESCLIENTE":"0","ESPROVEEDOR":"0","ESOTROS":"1","AUTORETENEDOR":"0","EXTRANJERO":"0","CIUDAD":"NULL","DIRECCION":"NULL","CONTACTO":"NULL","ESBANCO":"0","CODIGOACH":"NULL","OTROACH":"NULL","ARCHIVOBANCARIO":"NULL","SERVICIONOMINA":"0","TIPOAPORTANTE":"NULL","FORMAPRESENTACION":"NULL","CODIGOSUCURSAL":"NULL","NOMBRESUCURSAL":"NULL","TIPOPLANILLA":"NULL","EXCEPCION":"NULL","ESEMPRESAPILA":"0","ESEMPLEADO":"1","SEGUNDOCODIGO":"","ACTIVO":"1"}
            ]
            ';
    }
    public function modalidad()
    {
        return '[
            {"IDCLIENTE":"888888888","MODALIDADSERVICIO":"ADMON","TIPOMODALIDAD":"1","ESPECIFICAR":"0","SALARIOMLV":"0","SUBTRANSPORTE":"0","INCP_GENERAL":"0.0000","INCP_ARP":"0.0000","VERDIAS":"0","P_SUBTRANSPORTE":"0","PROV_MENSUALES":"0","ACTIVO":"1"},
            {"IDCLIENTE":"888888888","MODALIDADSERVICIO":"OPERATIVO","TIPOMODALIDAD":"1","ESPECIFICAR":"0","SALARIOMLV":"0","SUBTRANSPORTE":"0","INCP_GENERAL":"0.0000","INCP_ARP":"0.0000","VERDIAS":"0","P_SUBTRANSPORTE":"0","PROV_MENSUALES":"0","ACTIVO":"1"}
            ]
            ';
    }
    public function empresa_pila()
    {
        return '[
            {"IDTERCERO":"860002534","CODIGO":"14-1","TIPOSERVICIO":"3","NOMBRE":"ASEGURADORA DE VIDA COLSEGUROS"},
            {"IDTERCERO":"860002534","CODIGO":"EPS011","TIPOSERVICIO":"1","NOMBRE":"ASEGURADORA DE VIDA COLSEGUROS"},
            {"IDTERCERO":"860002528","CODIGO":"14-5","TIPOSERVICIO":"3","NOMBRE":"COMPAÑIA AGRICOLA DE SEGUROS DE VIDA SA"},
            {"IDTERCERO":"860002503","CODIGO":"14-7","TIPOSERVICIO":"3","NOMBRE":"CIA DE SEGUROS BOLIVAR SA"},
            {"IDTERCERO":"890300465","CODIGO":"14-8","TIPOSERVICIO":"3","NOMBRE":"COMPAÑIA DE SEGUROS DE VIDA AURORA"},
            {"IDTERCERO":"800228175","CODIGO":"14-25","TIPOSERVICIO":"3","NOMBRE":"RIESGOS PROFESIONALES COLMENA SA COMPAÑIA DE SEGUROS DE VIDA"},
            {"IDTERCERO":"860002183","CODIGO":"14-4","TIPOSERVICIO":"3","NOMBRE":"SEGUROS DE VIDA COLPATRIA SA"},
            {"IDTERCERO":"800226098","CODIGO":"14-26","TIPOSERVICIO":"3","NOMBRE":"BBVA SEGUROS DE VIDA COLOMBIA SA"},
            {"IDTERCERO":"890903790","CODIGO":"14-28","TIPOSERVICIO":"3","NOMBRE":"COMPAÑIA SURAMERICANA ADMINISTRADORA DE RIESGOS PROFESIONALES Y SEGUROS VIDA"},
            {"IDTERCERO":"860011153","CODIGO":"14-23","TIPOSERVICIO":"3","NOMBRE":"LA PREVISORA VIDA SA COMPAÑIA DE SEGUROS"},
            {"IDTERCERO":"860503617","CODIGO":"14-17","TIPOSERVICIO":"3","NOMBRE":"SEGUROS DE VIDA ALFA SA"},
            {"IDTERCERO":"860006578","CODIGO":"14-19","TIPOSERVICIO":"3","NOMBRE":"SEGUROS DE VIDA DEL ESTADO SA"},
            {"IDTERCERO":"860008645","CODIGO":"14-18","TIPOSERVICIO":"3","NOMBRE":"LIBERTY SEGUROS DE VIDA"},
            {"IDTERCERO":"860028415","CODIGO":"14-29","TIPOSERVICIO":"3","NOMBRE":"LA EQUIDAD SEGUROS DE VIDA ORGANISMO COOPERATIVO - LA EQUIDAD VIDA"},
            {"IDTERCERO":"830005997","CODIGO":"14-27","TIPOSERVICIO":"3","NOMBRE":"COMPAÑIA CENTRAL DE SEGUROS DE VIDA SA"},
            {"IDTERCERO":"860013816","CODIGO":"25-10","TIPOSERVICIO":"3","NOMBRE":"INSTITUTO DE SEGUROS SOCIALES ISS RIESGOS PROFESIONALES"},
            {"IDTERCERO":"860013816","CODIGO":"EPS006","TIPOSERVICIO":"1","NOMBRE":"INSTITUTO DE SEGUROS SOCIALES ISS RIESGOS PROFESIONALES"},
            {"IDTERCERO":"860013816","CODIGO":"25-11","TIPOSERVICIO":"2","NOMBRE":"INSTITUTO DE SEGUROS SOCIALES ISS RIESGOS PROFESIONALES"},
            {"IDTERCERO":"800229739","CODIGO":"230201","TIPOSERVICIO":"2","NOMBRE":"ADMINISTRADORA DE FONDOS DE PENSIONES Y CESANTIA PROTECCION SA"},
            {"IDTERCERO":"800229739","CODIGO":"3","TIPOSERVICIO":"9","NOMBRE":"ADMINISTRADORA DE FONDOS DE PENSIONES Y CESANTIA PROTECCION SA"},
            {"IDTERCERO":"800224808","CODIGO":"2","TIPOSERVICIO":"9","NOMBRE":"SOCIEDAD ADMINISTRADORA DE FONDOS DE PENSIONES Y CESANTIAS PORVENIR SA"},
            {"IDTERCERO":"800224808","CODIGO":"230301","TIPOSERVICIO":"2","NOMBRE":"SOCIEDAD ADMINISTRADORA DE FONDOS DE PENSIONES Y CESANTIAS PORVENIR SA"},
            {"IDTERCERO":"800231967","CODIGO":"230501","TIPOSERVICIO":"2","NOMBRE":"BBVA HORIZONTE SOCIEDAD ADMINISTRADORA DE FONDOS DE PENSIONES Y DE CESANTIAS SA"},
            {"IDTERCERO":"800231967","CODIGO":"1","TIPOSERVICIO":"9","NOMBRE":"BBVA HORIZONTE SOCIEDAD ADMINISTRADORA DE FONDOS DE PENSIONES Y DE CESANTIAS SA"},
            {"IDTERCERO":"800148959","CODIGO":"230801","TIPOSERVICIO":"2","NOMBRE":"FONDOS DE PENSIONES Y CESANTIA SANTANDER SA"},
            {"IDTERCERO":"800253055","CODIGO":"230901","TIPOSERVICIO":"2","NOMBRE":"SKANDIA ADMINISTRADORA DE FONDOS DE PENSIONES Y CESANTIAS SA"},
            {"IDTERCERO":"800253055","CODIGO":"4","TIPOSERVICIO":"9","NOMBRE":"SKANDIA ADMINISTRADORA DE FONDOS DE PENSIONES Y CESANTIAS SA"},
            {"IDTERCERO":"800227940","CODIGO":"0","TIPOSERVICIO":"9","NOMBRE":"COMPAÑIA COLOMBIANA ADMINISTRADORA DE FONDOS DE PENSIONES Y CESANTIAS SA COLFONDOS"},
            {"IDTERCERO":"800227940","CODIGO":"231001","TIPOSERVICIO":"2","NOMBRE":"COMPAÑIA COLOMBIANA ADMINISTRADORA DE FONDOS DE PENSIONES Y CESANTIAS SA COLFONDOS"},
            {"IDTERCERO":"860007379","CODIGO":"25-2","TIPOSERVICIO":"2","NOMBRE":"CAJA DE AUXILIOS Y PRESTACIONES DE LA ASOCIACION COLOMBIANA DE AVIADORES CIVILES ACDAC ÑCAXDAC\""},
            {"IDTERCERO":"899999734","CODIGO":"25-3","TIPOSERVICIO":"2","NOMBRE":"FONDO DE PREVISION SOCIAL DEL CONGRESO DE LA REPUBLICA ÑFONPRECON-"},
            {"IDTERCERO":"899999026","CODIGO":"25-4","TIPOSERVICIO":"2","NOMBRE":"CAJA DE PREVISION SOCIAL DE COMUNICACIONES -CAPRECOM-"},
            {"IDTERCERO":"899999026","CODIGO":"EPS020","TIPOSERVICIO":"1","NOMBRE":"CAJA DE PREVISION SOCIAL DE COMUNICACIONES -CAPRECOM-"},
            {"IDTERCERO":"800216278","CODIGO":"25-7","TIPOSERVICIO":"2","NOMBRE":"PENSIONES DE ANTIOQUIA"},
            {"IDTERCERO":"899999010","CODIGO":"25-8","TIPOSERVICIO":"2","NOMBRE":"CAJA NACIONAL DE PREVISION SOCIAL ÑCAJANALÑ"},
            {"IDTERCERO":"899999010","CODIGO":"EPS024","TIPOSERVICIO":"1","NOMBRE":"CAJA NACIONAL DE PREVISION SOCIAL ÑCAJANALÑ"},
            {"IDTERCERO":"860007336","CODIGO":"CCF22","TIPOSERVICIO":"4","NOMBRE":"CAJA COLOMBIANA DE SUBSIDIO FAMILIAR COLSUBSIDIO"},
            {"IDTERCERO":"860007331","CODIGO":"CCF18","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR AFIDRO"},
            {"IDTERCERO":"860013433","CODIGO":"CCF20","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR ASFAMILIAS"},
            {"IDTERCERO":"860013570","CODIGO":"CCF21","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR CAFAM"},
            {"IDTERCERO":"890102044","CODIGO":"CCF05","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR CAJACOPI ATLANTICO"},
            {"IDTERCERO":"890900840","CODIGO":"CCF02","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR CAMACOL COMFAMILIAR CAMACOL"},
            {"IDTERCERO":"800231969","CODIGO":"CCF68","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR CAMPESINA COMCAJA"},
            {"IDTERCERO":"890101994","CODIGO":"CCF07","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR COMFAMILIAR DEL ATLANTICO"},
            {"IDTERCERO":"891380056","CODIGO":"CCF61","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR COMFAMILIARES UNIDAS DEL VALLE COMFAUNION"},
            {"IDTERCERO":"890600842","CODIGO":"CCF03","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR COMFENALCO ANTIOQUIA"},
            {"IDTERCERO":"890600842","CODIGO":"EPS009","TIPOSERVICIO":"1","NOMBRE":"CAJA DE COMPENSACION FAMILIAR COMFENALCO ANTIOQUIA"},
            {"IDTERCERO":"890303093","CODIGO":"EPS012","TIPOSERVICIO":"1","NOMBRE":"CAJA DE COMPENSACION FAMILIAR COMFENALCO DEL VALLE DEL CAUCA - COMFENALCO VALLE"},
            {"IDTERCERO":"890303093","CODIGO":"CCF56","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR COMFENALCO DEL VALLE DEL CAUCA - COMFENALCO VALLE"},
            {"IDTERCERO":"890201578","CODIGO":"CCF40","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR COMFENALCO SANTANDER"},
            {"IDTERCERO":"860066942","CODIGO":"CCF24","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR COMPENSAR"},
            {"IDTERCERO":"860066942","CODIGO":"EPS008","TIPOSERVICIO":"1","NOMBRE":"CAJA DE COMPENSACION FAMILIAR COMPENSAR"},
            {"IDTERCERO":"890900841","CODIGO":"CCF04","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DE ANTIOQUIA COMFAMA"},
            {"IDTERCERO":"800219488","CODIGO":"CCF67","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DE ARAUCA COMFIAR"},
            {"IDTERCERO":"890270275","CODIGO":"CCF38","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DE BARRANCABERMEJA CAFABA"},
            {"IDTERCERO":"890102002","CODIGO":"CCF06","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DE BARRANQUILLA COMBARRANQUILLA"},
            {"IDTERCERO":"891800213","CODIGO":"CCF10","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DE BOYACA - COMFABOY"},
            {"IDTERCERO":"890304033","CODIGO":"CCF51","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DE BUENAVENTURA"},
            {"IDTERCERO":"890480110","CODIGO":"CCF09","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DE CARTAGENA"},
            {"IDTERCERO":"891900452","CODIGO":"CCF59","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DE CARTAGO - COMFACARTAGO"},
            {"IDTERCERO":"891080005","CODIGO":"CCF16","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DE CORDOBA COMFACOR"},
            {"IDTERCERO":"860045904","CODIGO":"CCF26","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DE CUNDINAMARCA - COMFACUNDI"},
            {"IDTERCERO":"890480023","CODIGO":"CCF08","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DE FENALCO - ANDI COMFENALCO CARTAGENA"},
            {"IDTERCERO":"860006606","CODIGO":"CCF23","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DE FENALCO COMFENALCO CUNDINAMARCA"},
            {"IDTERCERO":"890000381","CODIGO":"CCF43","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DE FENALCO COMFENALCO QUINDIO"},
            {"IDTERCERO":"890700148","CODIGO":"CCF50","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DE FENALCO DEL TOLIMA - COMFENALCO"},
            {"IDTERCERO":"890680023","CODIGO":"CCF28","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DE GIRARDOT COMGIRARDOT (EN LIQUIDACION)"},
            {"IDTERCERO":"890700679","CODIGO":"CCF47","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DE HONDA COMFAHONDA"},
            {"IDTERCERO":"892115006","CODIGO":"CCF30","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DE LA GUAJIRA"},
            {"IDTERCERO":"891200208","CODIGO":"CCF35","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DE NARIÑO"},
            {"IDTERCERO":"891480000","CODIGO":"CCF44","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DE RISARALDA- COMFAMILIAR RISARALDA"},
            {"IDTERCERO":"892400320","CODIGO":"CCF64","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DE SAN ANDRES Y PROVIDENCIA, ISLAS CAJASAI"},
            {"IDTERCERO":"892200015","CODIGO":"CCF41","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DE SUCRE"},
            {"IDTERCERO":"891900280","CODIGO":"CCF62","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DE TULUA - COMFAMILIAR DE TULUA"},
            {"IDTERCERO":"800003122","CODIGO":"CCF65","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DEL AMAZONAS CAFAMAZ"},
            {"IDTERCERO":"891190047","CODIGO":"CCF13","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DEL CAQUETA - COMFACA"},
            {"IDTERCERO":"844003392","CODIGO":"CCF69","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DEL CASANARE - COMFACASANARE"},
            {"IDTERCERO":"891500182","CODIGO":"CCF14","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DEL CAUCA - COMFACAUCA"},
            {"IDTERCERO":"892399989","CODIGO":"CCF15","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DEL CESAR COMFACESAR"},
            {"IDTERCERO":"891600091","CODIGO":"CCF29","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DEL CHOCO"},
            {"IDTERCERO":"891180008","CODIGO":"CCF32","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DEL HUILA - COMFAMILIAR"},
            {"IDTERCERO":"891780093","CODIGO":"CCF33","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DEL MAGDALENA"},
            {"IDTERCERO":"890500516","CODIGO":"CCF37","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DEL NORTE DE SANTANDER COMFANORTE"},
            {"IDTERCERO":"890500675","CODIGO":"CCF36","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DEL ORIENTE COLOMBIANO COMFAORIENTE"},
            {"IDTERCERO":"891200337","CODIGO":"CCF63","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DEL PUTUMAYO - COMFAMILIAR PUTUMAYO"},
            {"IDTERCERO":"890000062","CODIGO":"CCF42","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DEL QUINDIO COMFAMILIAR"},
            {"IDTERCERO":"890704737","CODIGO":"CCF46","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DEL SUR DEL TOLIMA CAFASUR"},
            {"IDTERCERO":"890700687","CODIGO":"CCF48","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DEL TOLIMA COMFATOLIMA"},
            {"IDTERCERO":"890303208","CODIGO":"CCF57","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR DEL VALLE DEL CAUCA COMFAMILIAR ANDI - COMFANDI"},
            {"IDTERCERO":"892000146","CODIGO":"CCF34","TIPOSERVICIO":"4","NOMBRE":"CAJA DE COMPENSACION FAMILIAR REGIONAL DEL META COFREM"},
            {"IDTERCERO":"890200106","CODIGO":"CCF39","TIPOSERVICIO":"4","NOMBRE":"CAJA SANTANDEREANA DE SUBSIDIO FAMILIAR CAJASAN"},
            {"IDTERCERO":"899999034","CODIGO":"PASENA","TIPOSERVICIO":"5","NOMBRE":"SENA"},
            {"IDTERCERO":"899999239","CODIGO":"PAICBF","TIPOSERVICIO":"6","NOMBRE":"INSTITUTO COLOMBIANO DE BIENESTAR FAMILIAR"},
            {"IDTERCERO":"800106339","CODIGO":"EPS001","TIPOSERVICIO":"1","NOMBRE":"COLMEDICA EPS"},
            {"IDTERCERO":"800130907","CODIGO":"EPS002","TIPOSERVICIO":"1","NOMBRE":"SALUD TOTAL SA ENTIDAD PROMOTORA DE SALUD"},
            {"IDTERCERO":"800140949","CODIGO":"EPS003","TIPOSERVICIO":"1","NOMBRE":"CAFESALUD MEDICINA PREPAGADA SA"},
            {"IDTERCERO":"800251440","CODIGO":"EPS005","TIPOSERVICIO":"1","NOMBRE":"ENTIDAD PROMOTORA DE SALUD SANITAS SA"},
            {"IDTERCERO":"800088702","CODIGO":"EPS010","TIPOSERVICIO":"1","NOMBRE":"SUSALUD EPS"},
            {"IDTERCERO":"800250119","CODIGO":"EPS013","TIPOSERVICIO":"1","NOMBRE":"ENTIDAD PROMOTORA DE SALUD ORGANISMO COOPERATIVO SALUDCOOP"},
            {"IDTERCERO":"830006404","CODIGO":"EPS014","TIPOSERVICIO":"1","NOMBRE":"HUMANA VIVIR SA  EPS  ARS"},
            {"IDTERCERO":"860512237","CODIGO":"EPS015","TIPOSERVICIO":"1","NOMBRE":"PROGRAMA SERVICIOS MEDICOS COLPATRIA SA ENTIDAD PROMOTORA DE SALUD"},
            {"IDTERCERO":"805000427","CODIGO":"EPS016","TIPOSERVICIO":"1","NOMBRE":"COOMEVA ENTIDAD PROMOTORA DE SALUD SA"},
            {"IDTERCERO":"830003564","CODIGO":"EPS017","TIPOSERVICIO":"1","NOMBRE":"ENTIDAD PROMOTORA DE SALUD FAMISANAR LIMITADA CAFAM-COLSUBSIDIO"},
            {"IDTERCERO":"805001157","CODIGO":"EPS018","TIPOSERVICIO":"1","NOMBRE":"ENTIDAD PROMOTORA DE SALUD SERVICIO OCCIDENTAL DE SALUD SA SOS"},
            {"IDTERCERO":"830009783","CODIGO":"EPS023","TIPOSERVICIO":"1","NOMBRE":"CRUZ BLANCA ENTIDAD PROMOTORA DE SALUD SA"},
            {"IDTERCERO":"891856000","CODIGO":"EPS025","TIPOSERVICIO":"1","NOMBRE":"CAPRESOCA EPS"},
            {"IDTERCERO":"804001273","CODIGO":"EPS026","TIPOSERVICIO":"1","NOMBRE":"SOLSALUD EPS SA"},
            {"IDTERCERO":"805004565","CODIGO":"EPS028","TIPOSERVICIO":"1","NOMBRE":"CALISALUD ENTIDAD PROMOTORA DE SALUD"},
            {"IDTERCERO":"814000608","CODIGO":"EPS030","TIPOSERVICIO":"1","NOMBRE":"ENTIDAD PROMOTORA DE SALUD CONDOR SA  -   EPS CONDOR SA"},
            {"IDTERCERO":"846000244","CODIGO":"EPS031","TIPOSERVICIO":"1","NOMBRE":"SELVASALUD SA ENTIDAD PROMOTORA DE SALUD SELVASALUD SA EPS"},
            {"IDTERCERO":"830074184","CODIGO":"EPS033","TIPOSERVICIO":"1","NOMBRE":"SALUDVIDA SA ENTIDAD PROMOTORA DE SALUD"},
            {"IDTERCERO":"805021984","CODIGO":"EPS034","TIPOSERVICIO":"1","NOMBRE":"SALUDCOLOMBIA ENTIDAD PROMOTORA DE SALUD SA"},
            {"IDTERCERO":"830096513","CODIGO":"EPS035","TIPOSERVICIO":"1","NOMBRE":"RED SALUD ATENCION HUMANA EPS SA"},
            {"IDTERCERO":"890904996","CODIGO":"EAS016","TIPOSERVICIO":"1","NOMBRE":"EMPRESAS PUBLICAS DE MEDELLIN DEPARTAMENTO MEDICO"},
            {"IDTERCERO":"800112806","CODIGO":"EAS027","TIPOSERVICIO":"1","NOMBRE":"FONDO DE PASIVO SOCIAL DE FERROCARRILES NACIONALES DE COLOMBIA"},
            {"IDTERCERO":"899999107","CODIGO":"EPS022","TIPOSERVICIO":"1","NOMBRE":"CONVIDA EPS"},
            {"IDTERCERO":"810000678","CODIGO":"EPS029","TIPOSERVICIO":"1","NOMBRE":"DE CALDAS EPS"},
            {"IDTERCERO":"830079672","CODIGO":"MIN001","TIPOSERVICIO":"1","NOMBRE":"FOSYGA"},
            {"IDTERCERO":"900074992","CODIGO":"EPS039","TIPOSERVICIO":"1","NOMBRE":"GOLDEN GROUP"},
            {"IDTERCERO":"800140680","CODIGO":"EPS007","TIPOSERVICIO":"1","NOMBRE":"UNIMEC"},
            {"IDTERCERO":"900336004","CODIGO":"25-14","TIPOSERVICIO":"2","NOMBRE":"ADMINISTRADORA COLOMBIANA DE PENSIONES COLPENSIONES"},
            {"IDTERCERO":"900156264","CODIGO":"EPS037","TIPOSERVICIO":"1","NOMBRE":"NUEVA EPS"},
            {"IDTERCERO":"800249241","CODIGO":"ESSC24","TIPOSERVICIO":"1","NOMBRE":"COOSALUD"},
            {"IDTERCERO":"806008394","CODIGO":"ESSC07","TIPOSERVICIO":"1","NOMBRE":"MUTUAL SER"},
            {"IDTERCERO":"901097473","CODIGO":"EPS044","TIPOSERVICIO":"1","NOMBRE":"MEDIMAS"}
            ]
            ';
    }
    public function configuracion_cliente()
    {
        return '[
            {"IDTERCERO":"888888888","ANO":"2023","FECHAREGISTRO":"01/01/2021","SALARIOMLV":"904136","SUBTRANSPORTE":"120150","INCP_GENERAL":"66.6667","INCP_ARP":"1000000","UVT":"297520000","VERDIAS":"1","P_SUBTRANSPORTE":"1","PROV_MENSUALES":"0","VOLANTE_PAGO":"1","VOLANTE_PAGO_LOGO":"0"}
            ]';
    }
    public function configuracion_correos()
    {
        return '[
            {"IDTERCERO":"888888888","CORREO":"prueba@gmail.com","CLAVE":"prueba","HOST":"smtp.gmail.com","PUERTO":"587","SOPORTA_SSL":"1"}
            ]
            ';
    }
    public function telefono_comunicaciones()
    {
        return '[
            {"IDTERCERO":"88888888","TIPO":"2","CONCEPTO":"3010000000"},
            {"IDTERCERO":"88888888","TIPO":"4","CONCEPTO":"deivibarraprueba@softdin.com"},
            {"IDTERCERO":"99999999","TIPO":"2","CONCEPTO":"3051111111"},
            {"IDTERCERO":"99999999","TIPO":"4","CONCEPTO":"ingridanielaprueba@softdin.com"},
            {"IDTERCERO":"888888888","TIPO":"4","CONCEPTO":"notificaciones@softdin.com"}
            ]';
    }
    public function cuenta_bancarria()
    {
        return '[
            {"IDTERCERO":"888888888","IDBANCO":"890903938","CUENTABANCARIA":"9999999999999","TIPOCUENTA":"1","CUENTACONTABLE":"333333333333","TRANSFERENCIABANCARIA":"1","PLANILLAUNICA":"1","ACTIVO":"1"},
            {"IDTERCERO":"88888888","IDBANCO":"890903938","CUENTABANCARIA":"11111111111","TIPOCUENTA":"1","CUENTACONTABLE":"NULL","TRANSFERENCIABANCARIA":"0","PLANILLAUNICA":"0","ACTIVO":"1"},
            {"IDTERCERO":"99999999","IDBANCO":"890903938","CUENTABANCARIA":"222222222","TIPOCUENTA":"1","CUENTACONTABLE":"NULL","TRANSFERENCIABANCARIA":"0","PLANILLAUNICA":"0","ACTIVO":"1"}
            ]
            ';
    }
    public function sucursal_pila()
    {
        return '[
            {"IDCLIENTE":"888888888","CODIGO":"5","SUCURSALPILA":"UNICO","ACTIVO":"1"}
            ]
            ';
    }
    public function concepto_novedad_empresa()
    {
        return '[
            {"Id":"1","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Salario"},
            {"Id":"2","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Subsidio Transporte"},
            {"Id":"3","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":" (  (  [1]  / 240 )  * 0,35 )","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Recargo Nocturno 0,35"},
            {"Id":"4","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":" (  (  [1]  / 240 )  * 1,25 )","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Horas Extras Diurnas 1,25"},
            {"Id":"5","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":" (  (  [1]  / 240 )  * 1,75 )","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Horas Extras Noctunas 1,75"},
            {"Id":"6","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":" (  (  [1]  / 240 )  * 1,75 )","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Horas Extras DF 1,75"},
            {"Id":"7","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":" (  (  [1]  / 240 )  * 2,1 )","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Recargo Nocturno DF 2,1"},
            {"Id":"8","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"(  (  [1]  / 240 )  * 2 )","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Horas Extras Diurna DF 2"},
            {"Id":"9","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":" (  (  [1]  / 240 )  * 2,5 )","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Horas Extras Noctuna DF 2,5"},
            {"Id":"12","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":" (  (  [1]  / 240 )  * 1,75 )","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Cuota de Ingreso"},
            {"Id":"13","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":" (  (  [1]  / 240 )  * 1,75 )","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Cuota de sostenimiento"},
            {"Id":"14","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Pago Incapacidad ARP <=1 dias"},
            {"Id":"15","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Pago Incapacidad IGE <=2 dias"},
            {"Id":"16","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Pago Incapacidad IGE > 2 dias"},
            {"Id":"17","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Pago Incapacidad IRP > 1 dia"},
            {"Id":"18","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Pago Licencia Maternidad"},
            {"Id":"21","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Aporte Valor UPC Adicional"},
            {"Id":"22","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Aporte Voluntario AFP Empleador"},
            {"Id":"23","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Aporte Voluntario AFP Inversion Empleado"},
            {"Id":"24","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Aporte Voluntario AFP No Retenido"},
            {"Id":"25","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Aporte Voluntario AFP Obligatorio Empleado"},
            {"Id":"26","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Embargo Comercial"},
            {"Id":"27","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Embargo de Alimentacion"},
            {"Id":"28","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Embargo de Cooperativa"},
            {"Id":"32","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Prestamo"},
            {"Id":"33","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Intereses"},
            {"Id":"41","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"( 100 / 100 )","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Incapacidad Accidente Trabajo"},
            {"Id":"42","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"( 2 / 3 )","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Incapacidad General"},
            {"Id":"43","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"( 100 / 100 )","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Licencia Maternidad"},
            {"Id":"44","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Traslado a Otra AFP"},
            {"Id":"45","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Traslado a Otra EPS"},
            {"Id":"46","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Variacion Permanente del Salario"},
            {"Id":"47","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Variacion de Centros de Trabajo"},
            {"Id":"48","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Traslado desde otra AFP"},
            {"Id":"49","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Traslado desde otra EPS"},
            {"Id":"50","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Suspencion Temporal Trabajo y/o Permiso no Remunerado"},
            {"Id":"51","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Aporte Social"},
            {"Id":"56","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Indegnización"},
            {"Id":"74","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Saldo a Consignar"},
            {"Id":"75","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Saldo Negativo"},
            {"Id":"76","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Cuota Cooperado Inicial"},
            {"Id":"1132","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Cuenta por Pagar"},
            {"Id":"1156","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Inversiones Arrieta Pastrana S.A"},
            {"Id":"1165","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Mercados Hector Sanchez"},
            {"Id":"1187","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Permiso o Licencia Remunerada"},
            {"Id":"72","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"3","CALCULO":"(  [1]  +  [2]  +  [3]  +  [4]  +  [5]  +  [6]  +  [7]  +  [8]  +  [9]  +  [14]  +  [15]  +  [16]  +  [17]  +  [18] )","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Base Prestacional"},
            {"Id":"73","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"3","CALCULO":"(  [72]  -  [2] )","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Base Seguridad Social"},
            {"Id":"52","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"(  [72]  )","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Liquidacion Compensacion Anual"},
            {"Id":"53","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"(  [72]  )","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Liquidacion Rendimiento Anual"},
            {"Id":"54","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"(  [72]  )","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Liquidacion Compensaciones Semestrales"},
            {"Id":"55","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"(  [72]  -  [2]  )","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Liquidacion Descanso Anual"},
            {"Id":"1168","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"3","CALCULO":"","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Grupo - Ingresos NO Prestacionales"},
            {"Id":"19","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"2","CALCULO":"(  [73]  *  ( 4 / 100 )  )","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"EPS Trabajador"},
            {"Id":"20","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"2","CALCULO":"(  [73]  *  ( 4 / 100 )  )","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"AFP Trabajador"},
            {"Id":"29","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"2","CALCULO":"(  [73]  )","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Retefuente"},
            {"Id":"30","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"2","CALCULO":"(  [73]  )","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"FondoFSP_Solidaridad"},
            {"Id":"31","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"2","CALCULO":"(  [73]  )","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"FondoFSP_Subsistencia"},
            {"Id":"34","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"2","CALCULO":"(  [73]  *  ( 12 / 100 )  )","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Prov. AFP Empleador"},
            {"Id":"35","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"2","CALCULO":"(  [73]  -  [14]  -  [15]  -  [16]  -  [17]  -  [18]  -  [55]  )","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Prov. ARP"},
            {"Id":"36","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"2","CALCULO":"(  [73]  *  ( 4 / 100 )  )","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Prov. Caja Compensacion"},
            {"Id":"37","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"2","CALCULO":"(  [72]  *  (  ( 100 / 12 )  / 100 )  )","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Prov. Cesantias"},
            {"Id":"38","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"2","CALCULO":"(  [37]  *  ( 12 / 100 )  )","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Prov. Intereses Cesantias"},
            {"Id":"39","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"2","CALCULO":"(  [72]  *  (  ( 100 / 12 )  / 100 )  )","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Prov. Primas"},
            {"Id":"40","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"2","CALCULO":" (  (  [72]  -  [2]  )  *  ( 4,16 / 100 )  )","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Prov. Vacaciones"},
            {"Id":"67","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"2","CALCULO":"","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Casino Mamonal"},
            {"Id":"69","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"2","CALCULO":"","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"CETEC LTDA"},
            {"Id":"1133","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"2","CALCULO":"(  [73]  *  ( 2 / 100 )  )","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Prov. ICBF"},
            {"Id":"1134","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"2","CALCULO":"(  [73]  *  ( 3 / 100 )  )","TIPO":"1","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"Prov. Sena"},
            {"Id":"225","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"2","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"25-14"},
            {"Id":"226","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"2","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"25-8"},
            {"Id":"227","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"EPS024"},
            {"Id":"228","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"2","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"14-27"},
            {"Id":"229","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"EPS028"},
            {"Id":"230","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"2","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"25-4"},
            {"Id":"231","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"EPS020"},
            {"Id":"232","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"2","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"25-2"},
            {"Id":"233","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"EPS025"},
            {"Id":"234","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"2","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"231001"},
            {"Id":"235","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"EPS030"},
            {"Id":"236","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"2","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"230501"},
            {"Id":"237","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"9","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"0"},
            {"Id":"238","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"EPS001"},
            {"Id":"239","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"3","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"14-25"},
            {"Id":"240","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"3","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"14-4"},
            {"Id":"241","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"MIN001"},
            {"Id":"243","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"9","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"1"},
            {"Id":"244","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"3","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"14-1"},
            {"Id":"245","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"EPS011"},
            {"Id":"246","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"3","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"14-5"},
            {"Id":"247","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"3","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"14-7"},
            {"Id":"248","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"3","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"14-23"},
            {"Id":"249","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"2","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"230201"},
            {"Id":"250","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"EPS037"},
            {"Id":"251","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"EPS007"},
            {"Id":"252","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"EPS022"},
            {"Id":"253","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"EPS039"},
            {"Id":"254","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"EPS029"},
            {"Id":"255","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"EAS027"},
            {"Id":"256","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"EPS035"},
            {"Id":"257","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"EPS034"},
            {"Id":"258","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"EPS033"},
            {"Id":"259","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"EPS031"},
            {"Id":"260","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"EPS023"},
            {"Id":"261","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"4","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"CCF08"},
            {"Id":"262","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"3","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"14-26"},
            {"Id":"263","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"3","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"14-8"},
            {"Id":"264","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"EAS016"},
            {"Id":"265","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"EPS026"},
            {"Id":"266","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"EPS018"},
            {"Id":"267","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"EPS017"},
            {"Id":"268","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"EPS016"},
            {"Id":"269","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"EPS015"},
            {"Id":"270","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"EPS014"},
            {"Id":"271","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"EPS013"},
            {"Id":"272","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"EPS010"},
            {"Id":"273","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"EPS005"},
            {"Id":"274","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"EPS003"},
            {"Id":"275","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"EPS002"},
            {"Id":"276","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"6","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"PAICBF"},
            {"Id":"277","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"5","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"PASENA"},
            {"Id":"278","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"4","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"CCF09"},
            {"Id":"279","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"2","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"25-7"},
            {"Id":"280","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"2","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"25-3"},
            {"Id":"281","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"9","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"4"},
            {"Id":"282","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"2","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"230901"},
            {"Id":"283","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"2","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"230801"},
            {"Id":"284","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"2","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"230301"},
            {"Id":"285","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"9","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"2"},
            {"Id":"286","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"9","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"3"},
            {"Id":"287","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"2","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"25-11"},
            {"Id":"288","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"3","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"14-29"},
            {"Id":"289","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"3","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"14-18"},
            {"Id":"290","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"3","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"14-19"},
            {"Id":"291","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"3","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"14-17"},
            {"Id":"1124","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"3","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"14-28"},
            {"Id":"1162","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"ESSC07"},
            {"Id":"1170","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"ESSC24"},
            {"Id":"1171","IDCONCEPTO":"","IDMODALIDADSERVICIO":"1","APLICACION":"1","CALCULO":"NULL","TIPO":"2","ESPECIFICAR":"0","CODAUXILIAR":"NULL","ACTIVO":"1","CONCEPTO":"EPS044"}
            ]
            ';
    }
    public function asignacion_contable()
    {
        return '[
            {"IDCONCEPTONOVEDADEMPRESA":"1","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510506","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"2","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510527","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"3","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510515","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"6","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510515","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"12","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510515","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"13","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510515","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"8","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510515","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"4","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510515","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"9","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510515","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"5","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510515","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"7","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510515","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"15","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510506","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"14","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510506","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"19","RUBROCONTABLE":"GASTOS","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"20","RUBROCONTABLE":"GASTOS","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"24","RUBROCONTABLE":"GASTOS","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"22","RUBROCONTABLE":"GASTOS","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"23","RUBROCONTABLE":"GASTOS","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"25","RUBROCONTABLE":"GASTOS","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"21","RUBROCONTABLE":"GASTOS","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"30","RUBROCONTABLE":"GASTOS","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"31","RUBROCONTABLE":"GASTOS","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"32","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"136525","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"37","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510530","CCCREDITO":"0","CACREDITO":"0","CREDITO":"261005","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"38","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510533","CCCREDITO":"0","CACREDITO":"0","CREDITO":"261010","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"39","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510536","CCCREDITO":"0","CACREDITO":"0","CREDITO":"261020","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"40","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510539","CCCREDITO":"0","CACREDITO":"0","CREDITO":"261015","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"34","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"35","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510568","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237006","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"36","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510572","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237010","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"52","RUBROCONTABLE":"GASTOS","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"261005","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"53","RUBROCONTABLE":"GASTOS","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"261010","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"54","RUBROCONTABLE":"GASTOS","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"261020","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"55","RUBROCONTABLE":"GASTOS","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"261015","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"74","RUBROCONTABLE":"GASTOS","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"250501","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"75","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"136525","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"226","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"230","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"232","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"228","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"234","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"280","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"236","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"287","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"279","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"284","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"249","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"283","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"282","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"239","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510568","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237006","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"240","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510568","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237006","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"244","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510568","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237006","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"288","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510568","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237006","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"248","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510568","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237006","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"289","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510568","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237006","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"247","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510568","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237006","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"291","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510568","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237006","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"262","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510568","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237006","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"290","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510568","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237006","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"246","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510568","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237006","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"263","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510568","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237006","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"278","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510572","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237010","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"261","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510572","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237010","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"274","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"227","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"229","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"231","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"233","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"238","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"245","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"235","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"252","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"268","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"260","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"254","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"264","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"266","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"267","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"255","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"241","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"253","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"270","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"256","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"257","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"269","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"275","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"271","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"258","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"273","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"259","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"265","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"272","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"251","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"237","RUBROCONTABLE":"GASTOS","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"261005","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"243","RUBROCONTABLE":"GASTOS","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"261005","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"285","RUBROCONTABLE":"GASTOS","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"261005","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"286","RUBROCONTABLE":"GASTOS","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"261005","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"281","RUBROCONTABLE":"GASTOS","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"261005","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"276","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510575","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237010","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"277","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510578","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237010","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"1124","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510568","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237006","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"1132","RUBROCONTABLE":"GASTOS","CCDEBITO":"0","CADEBITO":"0","DEBITO":"220501","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"29","RUBROCONTABLE":"GASTOS","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"236505","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"1156","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510548","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"1162","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"1170","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"1171","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"250","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"1174","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"1176","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"1177","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"1179","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"1181","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"1182","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"1183","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"1185","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"1186","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"225","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"1180","RUBROCONTABLE":"GASTOS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"510570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"1","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520506","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"2","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520527","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"3","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520515","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"6","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520515","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"12","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520515","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"13","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520515","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"8","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520515","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"4","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520515","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"9","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520515","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"5","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520515","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"7","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520515","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"15","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520524","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"14","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520524","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"19","RUBROCONTABLE":"VENTAS","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"20","RUBROCONTABLE":"VENTAS","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"24","RUBROCONTABLE":"VENTAS","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"22","RUBROCONTABLE":"VENTAS","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"23","RUBROCONTABLE":"VENTAS","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"25","RUBROCONTABLE":"VENTAS","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"21","RUBROCONTABLE":"VENTAS","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"30","RUBROCONTABLE":"VENTAS","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"31","RUBROCONTABLE":"VENTAS","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"32","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"136525","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"37","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520530","CCCREDITO":"0","CACREDITO":"0","CREDITO":"261005","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"38","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520533","CCCREDITO":"0","CACREDITO":"0","CREDITO":"261010","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"39","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520536","CCCREDITO":"0","CACREDITO":"0","CREDITO":"261020","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"40","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520539","CCCREDITO":"0","CACREDITO":"0","CREDITO":"261015","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"34","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"35","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520568","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237006","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"36","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520572","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237010","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"52","RUBROCONTABLE":"VENTAS","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"261005","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"53","RUBROCONTABLE":"VENTAS","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"261010","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"54","RUBROCONTABLE":"VENTAS","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"261020","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"55","RUBROCONTABLE":"VENTAS","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"261015","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"74","RUBROCONTABLE":"VENTAS","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"250501","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"75","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"136525","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"1132","RUBROCONTABLE":"VENTAS","CCDEBITO":"0","CADEBITO":"0","DEBITO":"220501","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"29","RUBROCONTABLE":"VENTAS","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"236505","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"1156","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520548","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"1","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720506","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"2","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720527","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"3","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720515","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"6","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720515","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"12","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720515","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"13","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720515","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"8","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720515","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"4","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720515","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"9","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720515","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"5","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720515","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"7","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720515","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"15","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720524","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"14","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720524","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"19","RUBROCONTABLE":"COSTO","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"20","RUBROCONTABLE":"COSTO","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"24","RUBROCONTABLE":"COSTO","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"22","RUBROCONTABLE":"COSTO","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"23","RUBROCONTABLE":"COSTO","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"25","RUBROCONTABLE":"COSTO","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"21","RUBROCONTABLE":"COSTO","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"30","RUBROCONTABLE":"COSTO","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"31","RUBROCONTABLE":"COSTO","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"32","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"136525","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"37","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720530","CCCREDITO":"0","CACREDITO":"0","CREDITO":"261005","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"38","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720533","CCCREDITO":"0","CACREDITO":"0","CREDITO":"261010","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"39","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720536","CCCREDITO":"0","CACREDITO":"0","CREDITO":"261020","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"40","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720539","CCCREDITO":"0","CACREDITO":"0","CREDITO":"261015","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"34","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"35","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720568","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237006","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"36","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720572","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237010","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"52","RUBROCONTABLE":"COSTO","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"261005","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"53","RUBROCONTABLE":"COSTO","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"261010","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"54","RUBROCONTABLE":"COSTO","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"261020","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"55","RUBROCONTABLE":"COSTO","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"261015","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"74","RUBROCONTABLE":"COSTO","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"250501","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"75","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"136525","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"1132","RUBROCONTABLE":"COSTO","CCDEBITO":"0","CADEBITO":"0","DEBITO":"220501","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"29","RUBROCONTABLE":"COSTO","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"236505","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"1156","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720548","CCCREDITO":"0","CACREDITO":"0","CREDITO":"","INCAPACIDAD":"","TIPO":"1"},
            {"IDCONCEPTONOVEDADEMPRESA":"226","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"230","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"232","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"228","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"234","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"280","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"236","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"287","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"279","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"284","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"249","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"283","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"282","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"239","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520568","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237006","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"240","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520568","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237006","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"244","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520568","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237006","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"288","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520568","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237006","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"248","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520568","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237006","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"289","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520568","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237006","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"247","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520568","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237006","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"291","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520568","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237006","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"262","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520568","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237006","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"290","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520568","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237006","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"246","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520568","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237006","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"263","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520568","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237006","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"278","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520772","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237010","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"261","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520772","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237010","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"274","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"227","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"229","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"231","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"233","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"238","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"245","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"235","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"252","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"268","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"260","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"254","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"264","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"266","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"267","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"255","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"241","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"253","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"270","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"256","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"257","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"269","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"275","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"271","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"258","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"273","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"259","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"265","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"272","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"251","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"237","RUBROCONTABLE":"VENTAS","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"261005","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"243","RUBROCONTABLE":"VENTAS","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"261005","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"285","RUBROCONTABLE":"VENTAS","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"261005","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"286","RUBROCONTABLE":"VENTAS","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"261005","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"281","RUBROCONTABLE":"VENTAS","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"261005","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"276","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520575","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237010","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"277","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520578","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237010","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"1124","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520568","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237006","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"1162","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"1170","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"1171","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"250","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"1174","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"1176","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"1177","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"1179","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"1181","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"1182","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"1183","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"1185","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"1186","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"225","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"1180","RUBROCONTABLE":"VENTAS","CCDEBITO":"1","CADEBITO":"0","DEBITO":"520570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"226","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"230","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"232","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"228","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"234","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"280","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"236","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"287","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"279","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"284","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"249","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"283","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"282","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"239","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720568","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237006","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"240","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720568","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237006","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"244","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720568","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237006","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"288","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720568","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237006","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"248","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720568","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237006","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"289","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720568","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237006","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"247","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720568","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237006","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"291","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720568","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237006","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"262","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720568","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237006","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"290","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720568","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237006","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"246","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720568","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237006","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"263","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720568","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237006","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"278","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720772","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237010","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"261","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720772","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237010","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"274","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"227","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"229","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"231","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"233","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"238","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"245","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"235","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"252","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"268","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"260","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"254","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"264","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"266","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"267","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"255","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"241","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"253","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"270","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"256","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"257","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"269","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"275","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"271","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"258","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"273","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"259","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"265","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"272","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"251","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"237","RUBROCONTABLE":"COSTO","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"261005","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"243","RUBROCONTABLE":"COSTO","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"261005","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"285","RUBROCONTABLE":"COSTO","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"261005","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"286","RUBROCONTABLE":"COSTO","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"261005","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"281","RUBROCONTABLE":"COSTO","CCDEBITO":"0","CADEBITO":"0","DEBITO":"","CCCREDITO":"0","CACREDITO":"0","CREDITO":"261005","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"276","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720575","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237010","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"277","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720578","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237010","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"1124","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720578","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237006","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"1162","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"1170","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"1171","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"250","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"1174","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"1176","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"1177","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"1179","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"1181","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"1182","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"1183","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"1185","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"1186","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720569","CCCREDITO":"0","CACREDITO":"0","CREDITO":"237005","INCAPACIDAD":"233595","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"225","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"2"},
            {"IDCONCEPTONOVEDADEMPRESA":"1180","RUBROCONTABLE":"COSTO","CCDEBITO":"1","CADEBITO":"0","DEBITO":"720570","CCCREDITO":"0","CACREDITO":"0","CREDITO":"238030","INCAPACIDAD":"","TIPO":"2"}
            ]';
    }
}