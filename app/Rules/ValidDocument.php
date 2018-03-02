<?php


namespace App\Rules;



class ValidDocument
{

    public function passes($attribute, $cedula)
    {
        if (is_null($cedula) || empty($cedula)) //compruebo si el numero enviado es vacio o null
            return false;

        // else
        if (is_numeric($cedula))  //caso contrario sigo el proceso
        {
            if(strlen($cedula)==13) { $cedula=substr($cedula, 0,10); }

            $total_caracteres = strlen($cedula);       //se suma el total de caracteres
            if ($total_caracteres==10)                //compruebo que tenga 10 digitos la cedula
            {
                $nro_region = substr($cedula, 0,2);      //extraigo los dos primeros caracteres de izq a der

                if ($nro_region>=1 && $nro_region<=24)  //Ini Region compruebo a que region pertenece esta cedula
                {

                    $ter_digito = substr($cedula, 2,1);    //extraigo el tercer digito de la cedula

                    if ($ter_digito < 6)              //Si es < a 6 corresponde a PERSONA NATURAL
                    {

                        $ult_digito = substr($cedula, 9,1);    //extraigo el decimo digito de la cedula
                        // $ult_digito=substr($cedula, -1,1);   //extraigo el ultimo digito de la cedula
                        $coef = array(2,1,2,1,2,1,2,1,2);
                        $suma=0;

                        for ($i=0;$i<=8;$i++)
                        {
                            // $valor = 0;
                            $valor = $cedula[$i] * $coef[$i];
                            if ($valor>9) { $valor = ($valor - 9); }
                            $suma = $suma + $valor;
                        }

                        $modulo = 10;
                        $residuo = fmod($suma, $modulo);

                        if($residuo==0) { $digito=0; } else { $digito=$modulo-$residuo; }

                        if($digito==10) { $digito='0'; } //si la suma nos resulta 10, el decimo digito es cero

                        //if ($digito==$ult_digito) {  return $cedula; } else {  return "-N"; } //comparo los digitos final y ultimo
                        if ($digito==$ult_digito) {  return true; } else {  return false; } //comparo los digitos final y ultimo

                    }
                    else
                    {
                        if($ter_digito == 9)              //Si es = a 9 corresponde a PERSONA JURIDICA
                        {
                            $ult_digito=substr($cedula, 9,1);    //extraigo el decimo digito de la cedula
                            //$ult_digito=substr($cedula, -1,1);   //extraigo el ultimo digito de la cedula
                            $coef = array(4,3,2,7,6,5,4,3,2);
                            $suma=0;

                            for($i=0;$i<=8;$i++)
                            {
                                $valor=0;
                                $valor=$cedula[$i]*$coef[$i];
                                $suma=$suma+$valor;
                            }

                            $modulo=11;
                            $residuo = fmod($suma, $modulo);

                            if($residuo==0) { $digito=0; } else { $digito=$modulo-$residuo; }

                            //if ($digito==$ult_digito) {  return $cedula; } else {  return "-J"; } //comparo los digitos final y ultimo
                            if ($digito==$ult_digito) {  return true; } else {  return false; } //comparo los digitos final y ultimo

                        }
                        else
                        {
                            if($ter_digito == 6)              //Si es = a 6 corresponde a EMPRESAS SECTOR PUBLICO
                            {
                                $ult_digito=substr($cedula, 8,1);    //extraigo el noveno digito de la cedula
                                //$ult_digito=substr($cedula, -2,1);   //extraigo el ultimo digito de la cedula
                                $coef = array(3,2,7,6,5,4,3,2);
                                $suma=0;

                                for($i=0;$i<=7;$i++)
                                {
                                    $valor=0;
                                    $valor=$cedula[$i]*$coef[$i];
                                    // if($valor>9) { $valor=($valor - 9); }
                                    $suma=$suma+$valor;
                                }

                                $modulo=11;
                                $residuo = fmod($suma, $modulo);

                                if($residuo==0) { $digito=0; } else { $digito=$modulo-$residuo; }

                                //if ($digito==$ult_digito) {  return $cedula; } else {  return "-P"; } //comparo los digitos final y ultimo
                                if ($digito==$ult_digito) {  return true; } else {  return false; } //comparo los digitos final y ultimo

                            }
                        }
                    }

                }
                else
                {
                    return false;
                }				//Fin Region compruebo a que region pertenece esta cedula
            }
        }

        return false;
    }

}