<?php  

	namespace App\Controller;

	
	use \Core\View;
	use \App\Models\DTO\Contenido as ContDTO;
	use \App\Models\DTO\Documento as DocDTO;
	use \App\Models\DTO\Categoria as CatDTO;
	use \App\Models\DTO\Gestion_Documento as GDDTO;
	use \App\Models\ContenidoDAO as ContDAO;
	use \App\Models\DocumentoDAO as DocDAO;
	use \App\Models\CategoriaDAO as CatDAO;
	use \App\Models\Sub_CategoriaDAO as SubCatDAO;
	use \App\Models\Gestion_DocumentoDAO as GDDAO;
	use \stdClass;

	/**
	*  Clase controlador para gestionar la informacion asociada a las distintas categorias existentes
	*  EJ: Manuales, Instructivos, Indicadores etc.
	*/
	class Contenido {

		/**
		 *  Metodo que se ejecuta por defecto, muestra la pagina principal del administrador
		 * carga las categorias registradas en la DB
		 */
		function index() {
			$categorias = CatDAO::select();
			$subCat = SubCatDAO::select();
			$data = $this->pushSubCategories($categorias, $subCat);
			View::set("categorias", $data);
			View::render("admin". DS . "index");
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
		 *  Metodo que trae la informacion de la categoria solicitada de la base de datos
		 * Obtiene: La imagen, el texto, y los documentos asociados a esa categoria
		 * @var $seccion identifica la categoria a obtener informacion de la DB
		 * @return objeto JSON con la informacion obtenida
		 */
		function getInfo($seccion, $id) {
			$categorias = CatDAO::select();
			$subCat = SubCatDAO::select();
			$sec = str_replace("_", " ", $seccion);
			$data = $this->pushSubCategories($categorias, $subCat);
			View::set("titulo", "gestión de $sec");
			View::set("categoria", $id);
			View::set("subtitulo", "A continuación podra gestionar la información de $sec, así como el contenido descargable asociado");
			View::set("categorias", $data);
			$contenido = ContDAO::select($id);
			$action = "update";
			if (empty($contenido)) {
				$contenido = new \stdClass();
				$contenido->id = 0;
				$contenido->imagen = "img_secciones.png";
				$contenido->desc_img = "";
				$contenido->texto = "";
				$action = "register";
			} else {
				$docs = DocDAO::select($contenido['id']);
				$contenido['docs'] = $docs;
			}
			$contenido = json_encode($contenido);
			View::set("contenido", json_decode($contenido));
			View::set("action", $action);
			View::render("admin". DS . "contenido");
		}

		/**
		 * Metodo que guarda o actualiza la informacion de las distintas categorias en la DB,
		 * sube la imagen relacionada con la categoria a la ruta especificada en la
		 * variable $patch
		 * @var $trs Indica el tipo de operacion a realizar: Insertar o Actualizar
		 * @return objeto json con la respuesta de guardar la informacion de la 
		 * categoria del modelo documental
		 */
		function loadCategory($trs) {
			if ($_POST['texto'] != '' and $_POST['desc_img'] != '' and $_POST['categoria'] != '') {
				
				$res = array();
				$text = htmlspecialchars($_POST['texto']);						
				$cat = htmlspecialchars($_POST['categoria']);
				$desc_img = htmlspecialchars($_POST['desc_img']);
				$name;

				if (isset($_FILES['archivo'])) {
					$type = $_FILES['archivo']['type'];
					if ($type == 'image/jpeg' OR $type == 'image/png' OR $type == 'image/jpg') {
						if (!$_FILES['archivo']['error']) {
							$patch = PROJECTPATH . '/uploads/';
							$tmp = $_FILES['archivo']['tmp_name'];
							$name = $_FILES['archivo']['name'];					
							move_uploaded_file($tmp, $patch . $name);							

						} else {
							print(json_encode(['ok' => false, 'error' => $_FILES['archivo']['error']]));
							exit();
						}
					} else {
						print(json_encode(['ok' => false, 'error' => 'Formato de imagen no valido']));
						exit();
					}
				} 

				else {
					if ($trs == 'register') {
						print(json_encode(['ok' => false, 'error' => 'Debe cargar una imagen']));
						exit();
					}
					else if($trs == 'update') {
						$name = $_POST['archivo'];
					}
					else {
						print(json_encode(['ok' => false, 'error' => 'Accion no valida']));
						exit();
					}
				}

				$cont = new ContDTO($cat, $name, $desc_img, $text, $_SESSION['admin']['ID']);

				if ($trs == 'register') {
					$response = ContDAO::insert($cont);
					print(json_encode($response));
						exit();
				}
				else if ($trs == 'update') {
					$response = ContDAO::update($cont);
					print(json_encode($response));
					exit();
				}
				else {
					print(json_encode(['ok' => false, 'error' => 'Accion no valida']));
					exit();
				}				

			} else {
				print(json_encode(['ok' => false, 'error' => 'Faltan campos por ingresar']));
			}
		}

		/**
		 *  Metodo que sube un documento al servidor y guarda la informacion referente en la DB
		 * @return objeto JSON con la respuesta a la transaccion
		 */
		function cargarDocumento() {			
			$title = htmlspecialchars($_POST['title_doc']);
			$desc = htmlspecialchars($_POST['desc_doc']);
			$file = $_FILES['file_doc'];
			$id_cont = htmlspecialchars($_POST['id_cat']);
			$expide = htmlspecialchars($_POST['expide_doc']);
			$ver = htmlspecialchars($_POST['version_doc']);
			$est = htmlspecialchars($_POST['estate_doc']);
			$rev = htmlspecialchars($_POST['rev_doc']);
			$apro = htmlspecialchars($_POST['aprov_doc']);
			$res;
			if ($id_cont > 0) {
				if (!empty($title) and !empty($desc) and isset($_FILES['file_doc']) and !empty($id_cont) and !empty($expide) and !empty($ver) and !empty($est)) {
					$type = end(explode(".", $_FILES['file_doc']['name']));
					if ($type == 'doc' or $type == 'docx' or $type == 'pdf' or $type == 'rar') {
						if (!$_FILES['file_doc']['error']) {

							if (!file_exists(PROJECTPATH . "/uploads/documentos/")) {
								mkdir(PROJECTPATH . "/uploads/documentos/");
							}
							$patch = PROJECTPATH . "/uploads/documentos/";
							move_uploaded_file($file['tmp_name'], $patch . $file['name']);
							$doc = new DocDTO($title, $desc, $id_cont, $file['name']);
							$res = DocDAO::load($doc);
							if($res['ok']) {								
								$id_documento = DocDAO::findMax();
								$obj = new GDDTO($id_documento,date('d/m/Y'),$expide,$ver,$est,$rev,$apro);
								$res = GDDAO::insert($obj);
							}
						}
						else {
							$text;
							switch ($_FILES['file_doc']['error']) {
						        case UPLOAD_ERR_NO_FILE:
						            $text = 'No se ha subido ningun fichero';
						            break;
						        case UPLOAD_ERR_INI_SIZE:
						        	$text = 'Archivo execede el tamaño permitido';
						        	break;
						        case UPLOAD_ERR_FORM_SIZE:
						            $text = 'Archivo execede el tamaño permitido';
						            break;
						        default:
						            $text = 'Error desconocido ' . $_FILES['file_doc']['error'];
			    			}
							$res = ['ok' => false, 'error' => $text];
						}
					}
					else {
						$res = ['ok' => false, 'error' => 'Extension del archivo no valida'];
					}
									
				}
				else {
					$res = ['ok' => false, 'error' => 'Debe ingresar todos los datos'];
				}
					
			} else {
				$res = ['ok' => false, 'error' => 'No información asociada a esta categoria'];
			}	
			print(json_encode($res));
		}
	}


?>