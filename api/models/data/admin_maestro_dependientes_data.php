<?php
// Se incluye la clase para validar los datos de entrada.
require_once('../../helpers/validator.php');
// Se incluye la clase padre.
require_once('../../models/handler/admin_maestros_dependiente_handler.php');

/*
 *	Clase para manejar el encapsulamiento de los datos de la tabla DEPENDIENTE.
 */
class DependientesData extends DependientesHandler
{
    /*
     *  Atributos adicionales.
     */
    private $data_error = null;

    /*
     *   Métodos para validar y establecer los datos.
     */

    // Métodos para el manejo de la tabla DEPENDIENTE.
    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            $this->data_error = 'El identificador del dependiente es incorrecto';
            return false;
        }
    }

    public function setCodigo($value, $min = 2, $max = 15)
    {
        if (!Validator::validateAlphanumeric($value)) {
            $this->data_error = 'El código debe ser un valor alfanumérico';
            return false;
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->codigo = $value;
            return true;
        } else {
            $this->data_error = 'El código debe tener una longitud entre ' . $min . ' y ' . $max;
            return false;
        }
    }

    public function setNombre($value, $min = 2, $max = 50)
    {
        if (!Validator::validateAlphanumeric($value)) {
            $this->data_error = 'El nombre debe ser un valor alfanumérico';
            return false;
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->nombre = $value;
            return true;
        } else {
            $this->data_error = 'El nombre debe tener una longitud entre ' . $min . ' y ' . $max;
            return false;
        }
    }

    /*
     *  Métodos para obtener los atributos adicionales.
     */
    public function getDataError()
    {
        return $this->data_error;
    }
}
?>
