<?php  

	namespace App\Controller;

	use \App\Models\CategoriaDAO as CatDAO;
	use \App\Models\Sub_CategoriaDAO as SubCatDAO;
	use \App\Models\DTO\Categoria as CatDTO;
	use \App\Models\ContenidoDAO as ContDAO;
	use \App\Models\DocumentoDAO as DocsDAO;
	use \Core\View;


	/**
	*  Clase controladora que gestiona las peticiones de los usuarios finales
	*/
	class Usuarios {
		
		function index() {
			$categorias = CatDAO::select();
			$subCat = SubCatDAO::select();
			$data = $this->pushSubCategories($categorias, $subCat);
			View::set("categorias", $data);			
			View::render("home". DS . "home");
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

		function secciones($id, $secc) {
			$categorias = CatDAO::select();
			$subCat = SubCatDAO::select();
			$data = $this->pushSubCategories($categorias, $subCat);
			$info = ContDAO::select($id);
			$docs = DocsDAO::select($id);
			View::set("categorias", $data);
			View::set("titulo", str_replace('_', ' ', $secc));
			View::set("desc", "A continuación podra visualizar la información de ".str_replace('_', ' ', $secc).", así como los archivos asociados");
			View::set("seccion", $info);
			View::set("docs", $docs);
			View::render("secciones". DS . "sections");
		}

		
	}

?>