<?php
  
   /**
   * @package Upload Wrapper
   * @version v0.1
   * @author  Lee Howarth
   */
   
   class Upload
   {
       private $name;
       
       private $size;
       
       private $type;
       
       private $tmp_name;
       
       private $error;
       
       public function __construct( $file )
       {
           if ( isset( $_FILES[ $file ] ) )
           {
                array_walk( $_FILES[ $file ], function( $val, $key )
                {                  
                    $this -> $key = $val;
                } );
                
                return;
           }
           
           $this -> error = 4;
       }
       
       public function getError()
       {
           $data = Array(
             1 => 'The uploaded file exceeds the max filesize.',
             2 => 'The uploaded file exceeds the max filesize.',
             3 => 'The uploaded file only partially uploaded.',
             4 => 'No file was uploaded.',
             6 => 'Missing a temporary folder.',
             7 => 'Failed to write to disk.',
             8 => 'A PHP extenstion stopped the file upload.'
           );
            
           return ( isset( $data[ $this -> error ] ) ) ? $data[ $this -> error ] : false;
       }
       
       public function getName()
       {                            
           return mb_ereg_replace( '[\\\\/:*?"<>|]', null, trim( $this -> name ) );
       }
       
       public function getSize()
       {
           return 0 + $this -> size;
       }
       
       public function getMime()
       {
           if ( $mime = shell_exec( 'file -b --mime-type ' . escapeshellarg( $this -> tmp_name ) ) )
           {
                return trim( $mime );
           }
           
           return $this -> type;
       }
       
       public function getPath()
       {
           return $this -> tmp_name;
       }
       
       public function getData()
       {
           try
           {
               $file = new SplFileObject( $this -> tmp_name, 'rb' );
               
               $data = null;
               
               for ( $file; $file -> valid(); $file -> next() )
               {
                   $data .= $file -> current();  
               }
               
               return $data;
           }
           catch ( RuntimeException $e )
           {
               
           }
           
           return null;
       }
       
       public function getExtension()
       {
           if ( ! ( $ext = pathinfo(  $this -> name, PATHINFO_EXTENSION ) ) )
           {
                return null;
           }
           
           return $ext;
       }
       
       public function remove()
       {
           return unlink( $this -> tmp_name );
       }
       
       public function move( $path )
       {
           return move_uploaded_file( $this -> tmp_name, $path );
       }
   }
