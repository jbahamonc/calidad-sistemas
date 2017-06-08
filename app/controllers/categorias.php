<?php  

	namespace App\Controller;


	use \App\Models\DTO\Sub_categorias as SubCatDTO;
	use \App\Models\DTO\Categoria as CatDTO;
	use \App\Models\CategoriaDAO as CatDAO;
	use \App\Models\Sub_CategoriaDAO as SubCatDAO;
	use \Core\View;


	/**
	*  Clase controladora que gestiona las peticiones realizadas sobre las distintas categorias de los modelos
	*/
	class Categorias {
		

		/**
		 * Metodo que muestra el formulario de registro de nuevas categorias
		 */
		function show() {
			$categorias = CatDAO::select();
			$subCat = SubCatDAO::select();
			$data = $this->pushSubCategories($categorias, $subCat);
			View::set("categorias", $data);
			View::render('admin' . DS . 'categorias');
		}

		/**
		 *  Metodo que crea los objetos de las categorias y asigna las sub-categorias a cada categoria
		 */
		private function pushSubCategories($cat, $subCat) {
			if (!empty($cat) and !empty($subCat)) {
				$obj = array();
				foreach ($cat as $value) {
					$id = $value[0];
					$newCat = new CatDTO($value[1]);
					$newCat->setId($id);
					$array = array();
					for ($i=0; $i < count($subCat); $i++) { 
						if ($id == $subCat[$i][2]) {	
							$array[] = $subCat[$i];
						}
					}
					$newCat->setSubCategorias($array);
					$obj[] = $newCat;
				}
			}
			return $obj;
		}

		/**
		 *  Metodo que captura los datos de la vista y los envia al DAO
		 */
		function insert() {
			$cat = $_POST['id_categoria'];
			$sub = $_POST['sub_categoria'];
			if (!empty($cat) and !empty($sub)) {
				$obj = new SubCatDTO($sub, $cat);
				$json = SubCatDAO::insert($obj);
			}
			else {
				$json = ['ok' => false, 'error' => 'Faltan datos por ingresar'];
			}

			print(json_encode($json));	
		}

		/**
		 *  Metodo que obtiene el id de la categoria hacer elminada y la envia al DAO
		 */
		function delete() {
			$id = $_POST['id'];
			if (!empty($id)) {
				$json = SubCatDAO::delete($id);
			}
			else {
				$json = ['ok' => false, 'error' => 'Falta el id de la subcategoria'];
			}

			print(json_encode($json));
		}
	}

?>