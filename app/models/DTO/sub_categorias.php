<?php  

	namespace App\Models\DTO;


	/**
	*  Clase para el manejo de las sub-categorias existentes
	*/
	class Sub_categorias {

		/**
		 * @var $_nombre nombre de la sub-categoria
		 */
		private $_nombre;

		/**
		 * @var $_id_categoria identifica a la categoria a la que pertenece
		 */
		private $_id_categoria;
		
		function __construct($nombre, $id_categoria) {
			$this->_nombre = $nombre;
			$this->_id_categoria = $id_categoria;
		}

		/* Metodos Guetter y Setter*/

		public function getNombre() {
			return $this->_nombre;
		}

		public function setNombre($nombre) {
			$this->_nombre = $nombre;
		}

		public function getIdCategoria() {
			return $this->_id_categoria;
		}

		public function setIdCategoria($id_cat) {
			$this->_id_categoria = $id_cat;
		}
	}

?>