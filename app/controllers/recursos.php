<?php  

	namespace App\Controller;

	use \Core\View;
	use \App\Models\CategoriaDAO as CatDAO;
	use \App\Models\Sub_CategoriaDAO as SubCatDAO;
	use \App\Models\FormacionDAO as FormDAO;
	use \App\Models\DTO\Categoria as CatDTO;
	use \App\Models\DTO\Personal as PerDTO;
	use \App\Models\DTO\Formacion as FormDTO;
	use \App\Models\Personal;

	/**
	*  Clase controlador que gestiona la administracion del equipo de trabajo
	*/
	class Recursos {
		
		function equipo_de_trabajo() {
			$categorias = CatDAO::select();
			$subCat = SubCatDAO::select();
			$data = $this->pushSubCategories($categorias, $subCat);
			$personal = Personal::select();
			View::set("categorias", $data);
			View::set("personal", json_encode($personal));
			View::render("admin". DS ."recursos");
		}

		/**
		 * Metodo que muestra el formulario de registro de personal
		 */
		function show() {
			$categorias = CatDAO::select();
			$subCat = SubCatDAO::select();
			$data = $this->pushSubCategories($categorias, $subCat);
			View::set("categorias", $data);
			View::render("admin" . DS . "save-person");
		}

		/**
		 *  Metodo que permite guardar en la base de datos la informacion del personal
		 *  @return obj JSON con la informacion de la transaccion
		 */
		function save() {
			$id = htmlspecialchars($_POST['id']);
			$nombre = htmlspecialchars($_POST['nombre']);
			$apellidos = htmlspecialchars($_POST['apellidos']);
			$telefono = htmlspecialchars($_POST['telefono']);
			$email = htmlspecialchars($_POST['email']);
			$cargo = htmlspecialchars($_POST['cargo']);
			$dir_lab = htmlspecialchars($_POST['dir_lab']);
			$url = htmlspecialchars($_POST['url']);
			$competencias = htmlspecialchars($_POST['competencias']);
			$formation = json_decode($_POST['formation']);
			$img = $_FILES['avatar'];
			$json;
			if (!empty($id) and !empty($nombre) and !empty($apellidos) and !empty($telefono) and 
				!empty($email) and !empty($cargo) and !empty($dir_lab) and !empty($url) and 
				!empty($img['name']) and !empty($competencias) and !empty($formation)) {
				
				$type = end(explode(".", $_FILES['avatar']['name']));
				if ($type == 'jpg' or $type == 'png' or $type == 'bmp' or $type == 'jpeg') {
					if(!$_FILES['avatar']['error']) {
						$per = new PerDTO($id, $nombre, $apellidos, $telefono, $email, $cargo, $dir_lab, $url, $img['name'], $competencias);
						$res = Personal::insert($per);
						$json = $res;
						if ($json['ok']) {
							if (!file_exists(PROJECTPATH . "/uploads/personal/avatar/")) {
								mkdir(PROJECTPATH . "/uploads/personal/avatar/", 0777, true);
							}
							$path = PROJECTPATH . "/uploads/personal/avatar/";
							move_uploaded_file($img['tmp_name'], $path . $img['name']);
							$doc = json_decode(Personal::find($id));
							foreach($formation as $val) {
								$form = new FormDTO($val->titulo, $val->fechaini, $val->fechafin, $val->tesis, $val->lugar, $doc[0]->id);
								$json = FormDAO::insert($form);
							}
						}
					}else {
						$text;
						switch ($_FILES['avatar']['error']) {
					        case UPLOAD_ERR_NO_FILE:
					            $text = 'No se ha subido ningun fichero';
					            break;
					        case UPLOAD_ERR_INI_SIZE:
					        	$text = 'Archivo execede el tamaño permitido 1';
					        	break;
					        case UPLOAD_ERR_FORM_SIZE:
					            $text = 'Archivo execede el tamaño permitido 2';
					            break;
					        default:
					            $text = 'Error desconocido ' . $_FILES['file_doc']['error'];
		    			}
						$json = ['ok' => false, 'error' => $text];
					}
				}else {
					$json = ['ok' => false, 'error' => "Extension de imagen no valida"];
				}
			}else {
				$json = ['ok' => false, 'error' => 'Faltan datos por ingresar'];
			}
			print(json_encode($json));
		}

		/**
		 *  Metodo que borra un integrante del personal
		 *  @return obj JSON con la respuesta a la transaccion
		 */
		function delete($id) {
			if (!empty($id)) {
				$res = Personal::delete($id);
			}
			else {
				$res = ['ok' => false, 'error' => 'No se encuentra ningun identificador'];
			}
			print(json_encode($res));
		}

		/**
		 * Metodo que obtiene la informacion de integrante del personal
		 * de la clase DAO correspondiente
		 */
		function info($id) {
			$categorias = CatDAO::select();
			$subCat = SubCatDAO::select();
			$data = $this->pushSubCategories($categorias, $subCat);
			$doc = Personal::find($id);
			$estudios = FormDAO::find($id);
			View::set("est", json_decode($estudios));
			View::set("categorias", $data);
			View::set('doc', json_decode($doc));
			View::render("admin". DS . "info");
		}

		/**
		 *  Metodo que recibe los datos del integrante del personal para enviarlos al DAO
		 */
		function update() {
			$id = htmlspecialchars($_POST['id']);
			$nombre = htmlspecialchars($_POST['nombre']);
			$apellidos = htmlspecialchars($_POST['apellidos']);
			$telefono = htmlspecialchars($_POST['telefono']);
			$email = htmlspecialchars($_POST['email']);
			$cargo = htmlspecialchars($_POST['cargo']);
			$dir_lab = htmlspecialchars($_POST['dir_lab']);
			$url = htmlspecialchars($_POST['url']);
			$competencias = htmlspecialchars($_POST['competencias']);
			$img = htmlspecialchars($_POST['img_old']);	
			$id_old = htmlspecialchars($_POST['id_old']);		
			$json;
			if (!empty($id) and !empty($nombre) and !empty($apellidos) and !empty($telefono) and 
				!empty($email) and !empty($cargo) and !empty($dir_lab) and !empty($url) and 
				!empty($img) and !empty($competencias)) {

				if (!empty($_FILES['avatar']['name'])) {
					unlink(PROJECTPATH . DS . "uploads". DS ."personal". DS ."avatar". DS . $img);
					$img = $_FILES['avatar'];
					$type = end(explode(".", $img['name']));
					if ($type == 'jpg' or $type == 'png' or $type == 'bmp' or $type == 'jpeg') {
						if(!$img['error']) {
							if (!file_exists(PROJECTPATH . "/uploads/personal/avatar/")) {
								mkdir(PROJECTPATH . "/uploads/personal/avatar/", 0777, true);
							}
							$path = PROJECTPATH . "/uploads/personal/avatar/";
							move_uploaded_file($img['tmp_name'], $path . $img['name']);
							
						}else {
							$text;
							switch ($img['error']) {
						        case UPLOAD_ERR_NO_FILE:
						            $text = 'No se ha subido ningun fichero';
						            break;
						        case UPLOAD_ERR_INI_SIZE:
						        	$text = 'Archivo execede el tamaño permitido 1';
						        	break;
						        case UPLOAD_ERR_FORM_SIZE:
						            $text = 'Archivo execede el tamaño permitido 2';
						            break;
						        default:
						            $text = 'Error desconocido ' . $img['error'];
			    			}
							$json = ['ok' => false, 'error' => $text];
						}
					}else {
						$json = ['ok' => false, 'error' => "Extension de imagen no valida"];
					}	
					$img = $img['name'];			
				}
				if (!isset($json['ok'])) {
					$per = new PerDTO($id, $nombre, $apellidos, $telefono, $email, $cargo, $dir_lab, $url, $img, $competencias);
					$json = Personal::update($per, $id_old);
				}
				
				print(json_encode($json));
			}
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