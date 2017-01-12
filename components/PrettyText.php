<?php
namespace pistol88\task\components;

/**
 * PrettyComment
 *
 * Заменяет на html теги текстовые ссылки на веб-страницы и картинки. Вырезает мат.
 *
 * 
 */

class PrettyText extends \yii\base\Component {

	private $text;
	private $nomat = array('деб', 'рбля', 'нахт', 'похл', 'похн', 'йнах', 'инах', 'янах', 'анах', 'санах', 'канах', 'ена', 'реба', 'себа', 'неба', 'абля', 'кеба', 'грёб', 'блях', 'добл', 'сук', 'дебил', 'гена', 'херсон', 'страх', 'херома', 'небуде', 'треб', 'хрен', 'был', 'греб', 'грёб', 'объ', 'похо', 'нахо', 'погон', 'учеб', 'онах', 'нахв', 'хлеб');
	private $images_hosts = array('vk.me/u');
	private $smiles = array(
					':)' => '/assets/images/smiles/smile.gif',
					':(' => '/assets/images/smiles/unsmile.gif',
					';)' => '/assets/images/smiles/ye.gif',
					':D' => '/assets/images/smiles/d.gif'
				);
    /**
     * Вырезает мат.
     *
     */
	function mat() {
		$text = $this->getText();

		$bad_word = array("/ху(й|и|я|е|л(и|е|ё))/si","/пи(з|с)(д|ж)/si","/бля/si","/бля(д|т|ц)/si","/(с|сц)ук(а|о|и)/si","/(:|_|-|вы|)еб(а|ок|ли|у|и|ен|еня)/si","/об(ъ)/si","/уеб/si","/заеб/si","/еб(а|и)(н|с|щ|ц)/si","/ебу(ч|щ)/si","/п(и|ы)д(о|е)р/si","/хер/si","/г(а|о)ндон/si","/залуп/si","/(ё|е)б(н|к|с)/si","/(ё|е)б(а|ы)/si","/(ё)б/si","/(ипаться|ниипет|хрена|нехира|кондом|нах|пох|йух)/si","/п(е|и)д(и|е|р|ар|ок)/si","/муд(ак|и|о)/si","/м(а|о)н(да)/si");

		$arr = explode(" ", $text);
		if(is_array($arr) AND isset($bad_word)) { 
			foreach ($arr AS $v) {
				$break = false;
				foreach($this->nomat as $nomat) {
					if(substr_count(mb_strtolower($v), $nomat)) {
						$val[] = $v;
						$break = true;
					}
				}
				if(!$break) {
					$error = 0;
					for($i=0;$i<count($bad_word);$i++) {
						if(preg_match($bad_word[$i],mb_strtolower($v))) $error++;
					}
					if($error>0) $val[] = preg_replace($bad_word, "***", mb_strtolower($v)); 
					else $val[] = $v;
				}
			}
			
			$this->setText(implode(" ", $val));
		} 
		
		return $this;		
	} 
				
    /**
     * Устанавливает текст, с которым будем работать.
     *
     * @param string $text
     * @return object
     */
	public function setText($text) {
		$this->text = $text;
		return $this;
	}
    /**
     * Возвращает текст, с которым будем работать.
     *
     * @return string
     */
	public function getText() {
		return trim($this->text);
	}
    /**
     * Преобразует коды смайлов в html картинки
     *
     * @return object
     */
	public function smiles($smiles = null) {
		if(empty($smiles)) {
			$smiles = $this->smiles;
		}
		$text = $this->getText();
		foreach($smiles as $code => $img) {
			$text = str_ireplace(" $code", " <img src=\"$img\" alt=\"$code\" title=\"$code\" class=\"pretty_smile\" /> ", $text);
		}
		$this->setText($text);
		return $this;
	}
    /**
     * Преобразует текстовые ссылки в html тег a
     *
     * @return object
     */
	public function links() {
		$preg_autolinks = array(
			'pattern' => array(
				"'(https?://[A-z0-9\.\?\+\-/_=&%#:;]+[\w/=]+)'si",
				"'([^/])(www\.[A-z0-9\.\?\+\-/_=&%#:;]+[\w/=]+)'si",
			),
			'replacement' => array(
				'<a href="$1" target="_blank" rel="nofollow">$1</a>',
				'$1<a href="http://$2" target="_blank" rel="nofollow">$2</a>',
			));
		$text = $this->getText();
		$text = preg_replace($preg_autolinks['pattern'], $preg_autolinks['replacement'], $text);
		$this->setText($text);
		return $this;
	}
    /**
     * Преобразует текстовые ссылки на картинки
	 * в html тег img
     *
	 * @param array $hosts список хостов
     * @return object
     */
	public function images($hosts = null) {
		if(empty($hosts)) {
			$hosts = $this->images_hosts;
		}
		if(!$hosts) return $this;
		$pattern = "'http://[A-z0-9\.\?\+\-/_=&%#:;]+[\w/=]+'si";
		preg_match_all($pattern, $this->text, $links);
		$text = $this->getText();
		foreach($links[0] as $link) {
			foreach($hosts as $host) {
				if(substr_count($link, $host)) {
					$text = str_replace("$link", "<div class=\"pretty_image\"><img src=\"$link\" /></div>", $text);
					break;
				}
			}
			
		}
		$this->setText($text);
		return $this;
	}
}