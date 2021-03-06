<?php 

namespace Plunder\Helpers\Cache;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Filesystem;
/**
* 
*/
class Cache 
{
	protected $finder;
	/**
	 * [__construct description]
	 * @param Finder     $finder [description]
	 * @param FileSystem $fs     [description]
	 */
	public function __construct(Finder $finder){
		$this->finder 	= $finder;
		return $this;
	}

	/**
	 * [verifyChanges Verifica se houve alteracoes nos arquivos geradores de determinado cache]
	 * @param  [type] $path  [apelido do arquivo]
	 * @param  array  $files [Array com arquivos geradores do cache]
	 * @return [boolean]     [true: arquivos alterados, false: arquivos mantidos]
	 */
	public function verifyChanges($path, $files = array()){
		//inicializa as variavéis possiveis do cache;
		$filesCache 	= null;
		$contentCache	= null;
		$pathFile = $this->generatePath($path);

		//Se enviado array de files vazio, não temos com o 
		//que comparar, então consideramos como alterado
		if ($files === array()): 
			//TODO: Incluir informação no LOG de que o 
			//verifyChanges foi chamado sem os arquivos de origem
			return true;
		endif;
		
		//Monta caminho do arquivo em cache, se o arquivo 
		//não existe é considerado como alterado
		if(!$this->existsFile($path)):
			return true;
		endif;

		$cache 			= json_decode(file_get_contents($pathFile), true);
		$filesCache 	= $cache['filesCache'];
		$contentCache	= $cache['contentCache'];
		//Se as variaveis continuam com os valores iniciais
		//provavelmente tivemos algum erro no comando eval ou
		//o cache foi geredo de forma errada
		if($filesCache === null && $contentCache === null):
			throw new \ErrorException("Problemas no arquivo de cache eval", 1);
		endif;

		//Se não foi inicializado o filesCache geramos um arquivo sem parametros
		//para futuras comparacoes
		if($filesCache === null):
			//TODO: Incluir log arquivo em cache sem filesCache e contentCache Array
			return true;
		endif;

		//Se a quantidade de $files e $filesCache forem diferentes
		//temos um alteracao
		if(count($files) != count($filesCache))
			return true;

		//Valida se o timestamp de atualizacao é o mesmo para 
		//todos os arquivos;
		foreach ($files as $key => $value):
			if(!array_key_exists($value, $filesCache)):
				return true;
				break;
			else:
				$stat = stat($value);
				if ($stat["mtime"] != $filesCache[$value]):
					return true;
					break;
				endif;
			endif;

		endforeach;

		return false;
	}
	/**
	 * [setCache Gera arquivo de cache]
	 * @param [type] $path    [nome do arquivo]
	 * @param [type] $content [conteudo do arquivo]
	 * @param Finder $finder  [Arquivos que geraram o cache]
	 */
	public function setCache($path, $content, Finder $finder = null){
		$pathFile = $this->generatePath($path);
		$files = array();

		if($finder == null) $finder = array();

		foreach ($finder as $key => $value):
			$files[$value->getPathname()] = $value->getMTime();
		endforeach;

		$dump = array(
			'contentCache'=>$content,
			'filesCache' => $files,
		);
		//$dump = sprintf("\$contentCache = %s; \n \$filesCache = %s;", var_export($content, true), var_export($files, true));

		$this->createDir($pathFile);
		file_put_contents($pathFile, json_encode($dump));
	}

	public function getCache($path){
		//eval(file_get_contents($this->generatePath($path)));
		$cache 			= json_decode(file_get_contents($this->generatePath($path)), true);
		$filesCache 	= $cache['filesCache'];
		$contentCache	= $cache['contentCache'];	
		return $contentCache;
	}

	public  function existsFile($path){
		return file_exists($this->generatePath($path));
		//return $this->fs->exists($this->generatePath($path));
	}

	private function generatePath($path){
		return sprintf("%s/app/cache/%s/%s/%s.cache", BASE_DIR, ENVIRONMENT, str_replace(".", "/", $path), $path);
		return ENVIRONMENT . str_replace(".", "/", $path) . "/".$path .".cache";
	}

	private function createDir($file){
		preg_match("/^([\w:\/\\\]+)\/[\w.]+/", $file, $matches);
		$aux = explode("/", $matches[1]);
		$path = '';
		foreach ($aux as $key => $value):
			$path .= $value ."/";
			if(!is_dir($path)):
				mkdir($path);
			endif;
		endforeach;


	}


}