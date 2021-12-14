<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function div($id = NULL,$atributo = array())
{
    $code   = '<div ';
    $code   .= ( $id != NULL )      ? 'id="'. $id .'" '         : '';
   
    if(count($atributo)>0)
        {
        foreach($atributo as $chave => $valor) 
            {
            $code   .="$chave =".'"'.$valor.'" ';
            }
        }
        
   
    $code   .= '>';
    return $code;
}

function div_close()
{
    return '</div>';
}



function a_tag($href = '', $title = '')
	{
        $link = '<a ';
        $link .= 'href="'.$href.'" ';
        //$link .= 'title="'.$title.'">';
        $link .= '>';
        $link .= $title;
        $link .= '</a>';
        return $link;
        }
/**
 * Generates HTML LABEL tags based on number supplied
 *
 * @access	public
 * @param	integer
 * @return	string
 */

	function label($id = NULL,$conteudo = '',$atributo = array())
	{
            $code='<label ';
             $code   .= ( $id != NULL )      ? 'id="'. $id .'" '         : '';
            if(count($atributo)>0)
                {
                foreach($atributo as $chave => $valor) 
                    {
                    $code   .="$chave =".'"'.$valor.'" ';
                    }
                }
             $code.='>'.$conteudo.'</label>';
            return $code;
	}
    
    	function span($id = NULL,$conteudo = '',$atributo = array())
	{
            $code='<span ';
             $code   .= ( $id != NULL )      ? 'id="'. $id .'" '         : '';
            if(count($atributo)>0)
                {
                foreach($atributo as $chave => $valor) 
                    {
                    $code   .="$chave =".'"'.$valor.'" ';
                    }
                }
             $code.='>'.$conteudo.'</span>';
            return $code;
	}

   
if ( ! function_exists('dt'))
{
    function dt($list, $attributes = '')
    {
        return _list('dt', $list, $attributes);
    }
}

  
if ( ! function_exists('_list'))
{
	function _list($type = 'ul', $list, $attributes = '', $depth = 0)
	{
            $subType='li';
            if($type == 'dt')
                {
                $subType='dl';
                }
		// If an array wasn't submitted there's nothing to do...
		if ( ! is_array($list))
		{
		return $list;
		}

		// Set the indentation based on the depth
		$out = str_repeat(" ", $depth);

		// Were any attributes submitted?  If so generate a string
		if (is_array($attributes))
		{
			$atts = '';
			foreach ($attributes as $key => $val)
			{
				$atts .= ' ' . $key . '="' . $val . '"';
			}
			$attributes = $atts;
		}
		elseif (is_string($attributes) AND strlen($attributes) > 0)
		{
			$attributes = ' '. $attributes;
		}

		// Write the opening list tag
		$out .= "<".$type.$attributes.">\n";

		// Cycle through the list elements.  If an array is
		// encountered we will recursively call _list()

		static $_last_list_item = '';
		foreach ($list as $key => $val)
                    {
                    $atts_filho = ' ';
                    $valor=$val;
                    if (is_array($val))
                        {
                        
                        $valor=$val[0];
                        $atributos_filho = $val[1];
     
                        if (is_array($atributos_filho))
                            {
                           
                            foreach ($atributos_filho as $chave_filho => $valor_filho)
                                {
				$atts_filho .= ' ' . $chave_filho . '="' . $valor_filho . '"';
                                }
                            
                            }
//                        else{
//                         $atts_filho = ' CLASS="3" ';   
//                        }
                        }
                    
			$_last_list_item = $key;

			$out .= str_repeat(" ", $depth + 2);
			$out .= "<".$subType.$atts_filho.">";

			if ( ! is_array($valor))
			{
				$out .= $valor;
			}
			else
			{
				$out .= $_last_list_item."\n";
				$out .= _list($type, $valor, '', $depth + 4);
				$out .= str_repeat(" ", $depth + 2);
			}

			$out .= "</".$subType.">\n";
		}

		// Set the indentation for the closing tag
		$out .= str_repeat(" ", $depth);

		// Write the closing list tag
		$out .= "</".$type.">\n";

		return $out;
	}
}

?>