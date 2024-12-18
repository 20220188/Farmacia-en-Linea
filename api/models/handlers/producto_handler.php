<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');
/*
*	Clase para manejar el comportamiento de los datos de la tabla PRODUCTO.
*/

//StuddlyCaps
class ProductoHandler
{
    /*
    *   Declaración de atributos para el manejo de datos.
    */

    // Atributos de la tabla PRODUCTO.
    protected $id = null;
    protected $nombre = null;
    protected $descripcion = null;
    protected $imagen = null;
    protected $id_categoria = null;
    protected $id_tipo_producto = null;
    protected $id_deporte = null;
    protected $id_genero = null;
    // Atributos de la tabla DETALLE_PRODUCTO.
    protected $id_detalle_producto = null;
    protected $precio = null;
    protected $existencias = null;
    protected $id_talla = null;
    protected $id_producto = null;

    //Atributos de la tabla VALORACIONES_PRODUCTOS
    protected $id_valoracion = null;
    protected $comentario = null;
    protected $valoracion = null;
    protected $id_cliente = null;
    protected $estado_valoracion = null;

    // Atributos para los reportes
    protected $precioMin = null;
    protected $precioMax = null;

    // Constante para establecer la ruta de las imágenes.
    const RUTA_IMAGEN = '../../images/productos/';

    /*
    *   Métodos para realizar las operaciones SCRUD en tabla PRODUCTO (search, create, read, update, and delete).
    */
    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT id_producto, imagen, nombre_producto, descripcion, nombre_categoria, tipo_producto    
                FROM tb_productos
                INNER JOIN tb_categorias USING(id_categoria)
                INNER JOIN tb_tipo_productos USING(id_tipo_producto)
                WHERE nombre_producto LIKE ? OR descripcion LIKE ? OR nombre_categoria LIKE ? OR tipo_producto LIKE ? OR nombre_deporte LIKE ? OR genero LIKE ?
                ORDER BY nombre_producto';
        $params = array($value, $value, $value, $value, $value, $value);
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO tb_productos(nombre_producto, descripcion, imagen, id_categoria,id_tipo_producto)
                    VALUES(?, ?, ?, ?, ?)';
        $params = array($this->nombre, $this->descripcion, $this->imagen, $this->id_categoria, $this->id_tipo_producto);
        //esto funciona para ver los valores que toma el arreglo print_r($params);.
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_producto, imagen, nombre_producto, descripcion, nombre_categoria, tipo_producto  
                FROM tb_productos
                INNER JOIN tb_categorias USING(id_categoria)
                INNER JOIN tb_tipo_productos USING(id_tipo_producto)
                ORDER BY nombre_producto';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_producto, nombre_producto, descripcion,imagen, id_categoria, id_tipo_producto
                FROM tb_productos 
                WHERE id_producto = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }



    public function readFilename()
    {
        $sql = 'SELECT imagen
                FROM tb_productos
                WHERE id_producto = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE tb_productos 
                SET imagen = ?, nombre_producto = ?, descripcion = ?, id_categoria = ?, id_tipo_producto = ?
                WHERE id_producto = ?';
        $params = array($this->imagen, $this->nombre, $this->descripcion, $this->id_categoria, $this->id_tipo_producto, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM tb_productos
                WHERE id_producto = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    /*
    *   Métodos para realizar las operaciones SCRUD en tabla DETALLE?PRODUCTO (search, create, read, update, and delete).
    */

    public function createRowDetalleProducto()
    {
        $sql = 'INSERT INTO tb_detalle_productos(precio, cantidad_disponible, id_producto)
                    VALUES(?, ?, ?)';
        $params = array($this->precio, $this->existencias, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function readAllDetalle()
    {
        $sql = 'SELECT dp.id_detalle_producto, dp.precio,dp.id_producto, dp.cantidad_disponible, p.nombre_producto
        FROM tb_detalle_productos dp
        INNER JOIN tb_productos p USING(id_producto)
        WHERE dp.id_producto = ?';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }

    public function readOneDetalle()
    {
        $sql = 'SELECT id_detalle_producto, precio, cantidad_disponible, id_producto
                FROM tb_detalle_productos
                INNER JOIN tb_productos USING(id_producto) 
                WHERE id_detalle_producto = ?';
        $params = array($this->id_detalle_producto);
        return Database::getRow($sql, $params);
    }

    public function updateRowDetalle()
    {
        $sql = 'UPDATE tb_detalle_productos 
                SET precio = ?, cantidad_disponible = ? 
                WHERE id_detalle_producto = ?';
        $params = array($this->precio, $this->existencias, $this->id_detalle_producto);
        return Database::executeRow($sql, $params);
    }

    public function deleteRowDetalle()
    {
        $sql = 'DELETE FROM tb_detalle_productos
                WHERE id_detalle_producto = ?';
        $params = array($this->id_detalle_producto);
        return Database::executeRow($sql, $params);
    }

    /*
    *   Métodos para realizar las operaciones SCRUD en tabla tb_valoraciones_productos (search, create, read, update, and delete).
    */



    public function readAllValoracion()
    {
        $sql = 'SELECT v.id_valoracion, v.comentario, v.valoracion,v.id_detalle, dp.id_producto, c.nombre_cliente, v.estado_valoracion
        FROM tb_valoraciones v
        INNER JOIN tb_clientes c USING(id_cliente)
        INNER JOIN tb_detalle_pedidos dp USING(id_detalle)
        WHERE dp.id_producto = ?';
        $params = array($this->id_producto);
        return Database::getRows($sql, $params);
    }

    public function readOneValoracion()
    {
        $sql = 'SELECT id_valoracion, estado_valoracion
                FROM tb_valoraciones
                WHERE id_valoracion = ?';
        $params = array($this->id_valoracion);
        return Database::getRow($sql, $params);
    }

    public function updateRowValoracion()
    {
        $sql = 'UPDATE tb_valoraciones
        SET estado_valoracion = !(estado_valoracion )
        WHERE id_valoracion = ?';
        $params = array($this->id_valoracion);
        return Database::executeRow($sql, $params);
    }

    public function deleteRowValoracion()
    {
        $sql = 'DELETE FROM tb_valoraciones
                WHERE id_valoracion = ?';
        $params = array($this->id_valoracion);
        return Database::executeRow($sql, $params);
    }




    /*CONSULTAS PARA FILTRAR RESULTADOS POR CATEGORIAS EN EL SITIO PUBLICO */

    public function readProductoxCategoria()
{
    // Consulta base para obtener los productos y sus categorías
    $sql = 'SELECT id_producto, imagen, nombre_producto, descripcion, nombre_categoria, tipo_producto  
            FROM tb_productos
            INNER JOIN tb_categorias ON tb_productos.id_categoria = tb_categorias.id_categoria
            INNER JOIN tb_tipo_productos ON tb_productos.id_tipo_producto = tb_tipo_productos.id_tipo_producto
            WHERE 1'; // Se usa WHERE 1 para facilitar la adición de condiciones

    $params = array();

    // Agregar condición para id_producto si está definido
    if ($this->id_producto != null) {
        $sql .= ' AND id_producto = ?';
        $params[] = $this->id_producto;
    }

    // Agregar condición para id_categoria si está definido
    if ($this->id_categoria != null) {
        $sql .= ' AND tb_productos.id_categoria = ?';
        $params[] = $this->id_categoria;
    }

    // Agregar condición para id_tipo_producto si está definido
    if ($this->id_tipo_producto != null) {
        $sql .= ' AND tb_productos.id_tipo_producto = ?';
        $params[] = $this->id_tipo_producto;
    }

    // Ordenar por nombre del producto
    $sql .= ' ORDER BY nombre_producto';

    // Ejecutar la consulta y devolver los resultados
    return Database::getRows($sql, $params);
}


    public function readProductos()
    {
        $sql = 'SELECT id_producto, imagen, nombre_producto, descripcion, nombre_categoria, tipo_producto  
        FROM tb_productos
        INNER JOIN tb_categorias USING(id_categoria)
        INNER JOIN tb_tipo_productos USING(id_tipo_producto)
        WHERE id_producto != 0';
        $params = array();
        if ($this->id_categoria != null) {
            $sql .= ' AND id_categoria = ?';
            array_push($params, $this->id_categoria);
        }
        if ($this->id_tipo_producto != null) {
            $sql .= ' AND id_tipo_producto = ?';
            array_push($params, $this->id_tipo_producto);
        }
        $sql .= ' ORDER BY nombre_producto';
        return Database::getRows($sql, $params);
    }


    public function searchRowsPublic()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT id_producto, imagen, nombre_producto, descripcion, nombre_categoria, tipo_producto, nombre_deporte,genero    
                FROM tb_productos
                INNER JOIN tb_categorias USING(id_categoria)
                INNER JOIN tb_tipo_productos USING(id_tipo_producto)
                INNER JOIN tb_deportes USING(id_deporte)
                INNER JOIN tb_generos USING(id_genero)
                WHERE nombre_producto LIKE ? OR descripcion LIKE ? OR nombre_categoria LIKE ? OR tipo_producto LIKE ? OR nombre_deporte LIKE ? OR genero LIKE ?';
        $params = array($value, $value, $value, $value, $value, $value);
        if ($this->id_categoria != null) {
            $sql .= ' AND id_categoria = ?';
            array_push($params, $this->id_categoria);
        }
        if ($this->id_tipo_producto != null) {
            $sql .= ' AND id_tipo_producto = ?';
            array_push($params, $this->id_tipo_producto);
        }
        if ($this->id_genero != null) {
            $sql .= ' AND id_genero = ?';
            array_push($params, $this->id_genero);
        }
        if ($this->id_deporte != null) {
            $sql .= ' AND id_deporte = ?';
            array_push($params, $this->id_deporte);
        }
        $sql .= ' ORDER BY nombre_producto';
        return Database::getRows($sql, $params);
    }


    public function readOnePublica()
    {
        $sql = 'SELECT id_detalle_producto, id_producto, precio, cantidad_disponible, imagen, descripcion, nombre_producto
                FROM tb_detalle_productos
                INNER JOIN tb_productos USING(id_producto)
                WHERE id_producto = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function readAllMovil($id_categoria = null, $id_deporte = null)
    {
        $sql = 'SELECT id_detalle_producto, nombre_producto, imagen, precio
            FROM tb_detalle_productos
            INNER JOIN tb_productos USING(id_producto)';

        $params = array();

        // Construir la condición SQL según los parámetros recibidos
        if ($id_categoria !== null && $id_deporte === null) {
            $sql .= ' WHERE id_categoria = ?';
            $params = array($id_categoria);
        }
        if ($id_deporte !== null && $id_categoria === null) {
            $sql .= ' WHERE id_deporte = ?';
            $params = array($id_deporte);
        }
        if ($id_categoria !== null && $id_deporte !== null) {
            $sql .= ' WHERE id_categoria = ? AND id_deporte = ?';
            $params = array($id_categoria, $id_deporte);
        }

        return Database::getRows($sql, $params);
    }


    /*
    *   Métodos para generar gráficos.
    */
    public function cantidadProductosCategoria()
    {
        $sql = 'SELECT nombre_categoria, COUNT(id_producto) cantidad
                FROM tb_productos
                INNER JOIN tb_categorias USING(id_categoria)
                GROUP BY nombre_categoria ORDER BY cantidad DESC ';
        return Database::getRows($sql);
    }


    public function ProductosTopVendidos()
    {
        $sql = 'SELECT nombre_producto, SUM(cantidad_pedido) total
                FROM tb_detalle_pedidos
                INNER JOIN tb_productos USING(id_producto)
                GROUP BY nombre_producto
                ORDER BY total DESC
                LIMIT 5';
        return Database::getRows($sql);
    }

    public function cantidadProductosTipoP()
    {
        $sql = 'SELECT nombre_producto, cantidad_disponible 
                FROM tb_detalle_productos
                INNER JOIN tb_productos USING(id_producto)
                WHERE id_tipo_producto = ?
                GROUP BY nombre_producto
                ORDER BY cantidad_disponible DESC
                LIMIT 5';
        $params = array($this->id_tipo_producto);
        return Database::getRows($sql, $params);
    }


    /*
    *   Métodos para generar reportes.
    */

    public function productosCategoria()
    {
        $sql = 'SELECT nombre_producto, precio, cantidad_disponible
                FROM tb_detalle_productos
                INNER JOIN tb_productos USING(id_producto)
                INNER JOIN tb_categorias USING(id_categoria)
                WHERE id_categoria = ?
                ORDER BY nombre_producto';
        $params = array($this->id_categoria);
        return Database::getRows($sql, $params);
    }

    public function productosDeporte()
    {
        $sql = 'SELECT nombre_producto, precio, cantidad_disponible
                FROM tb_detalle_productos
                INNER JOIN tb_productos USING(id_producto)
                WHERE id_deporte = ?
                ORDER BY nombre_producto';
        $params = array($this->id_deporte);
        return Database::getRows($sql, $params);
    }

    public function productosPrecios()
    {
        $sql = 'SELECT nombre_producto, precio, cantidad_disponible, descripcion
                FROM tb_detalle_productos
                INNER JOIN tb_productos USING(id_producto)
                WHERE precio BETWEEN ? AND ?
                ORDER BY precio DESC';
        $params = array($this->precioMin, $this->precioMax);
        return Database::getRows($sql, $params);
    }

    public function productosDeporteGeneral()
    {
        $sql = 'SELECT nombre_producto, precio, cantidad_disponible
                FROM tb_detalle_productos
                INNER JOIN tb_productos USING(id_producto)
                WHERE id_deporte = ?
                ORDER BY precio DESC';
        $params = array($this->id_deporte);
        return Database::getRows($sql, $params);
    }

}
