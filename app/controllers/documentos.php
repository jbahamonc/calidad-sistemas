<?php  
	
	namespace App\Controller;

	use \Core\View;
	use \App\Models\DocumentoDAO as DocDAO;
	use \App\Models\CategoriaDAO as CatDAO;
	use \App\Models\Gestion_DocumentoDAO as GDDAO;
	use \App\Models\Sub_CategoriaDAO as SubCatDAO;
	use \App\Models\DTO\Categoria as CatDTO;


	/**
	*  Clase controladora que gestiona la administración de los documentos cargados en el sistema
	*/
	class Documentos {
		
		function index() {
			$categorias = CatDAO::select();
			$subCat = SubCatDAO::select();
			$data = $this->pushSubCategories($categorias, $subCat);
			$listDoc = GDDAO::findAll();
			View::set('doc_control', json_decode($listDoc));
			View::set("categorias", $data);
			View::render("admin". DS . "documentos");
		}

		/**
		 * Metodo que borra un documento de la DB y del servidor
		 * @return obj JSON con informacion de la transaccion
		 */
		function delete() {
			$id = htmlspecialchars($_POST['id']);
			$doc = htmlspecialchars($_POST['doc']);
			$json;
			if (!empty($id) and !empty($doc)) {
				$res = DocDAO::delete($id);
				if ($res['ok']) {
					if (file_exists(PROJECTPATH . DS . 'uploads' . DS . 'documentos' . DS . $doc)) {
						unlink(PROJECTPATH . DS . 'uploads' . DS . 'documentos' . DS . $doc);
					}
				}
				$json = $res;
				
			} else {
				$json = ['ok' => false, 'error' => 'Faltan datos'];
			}
			print(json_encode($json));
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
	}

?>