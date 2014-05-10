PHP-Upload
==========

A simple file upload wrapper for php.

The getName method uses a windows like method by removing \/:*?"<>| from the name.

The getMime method uses a non standard way of obtaining the mime type, i am not aware of how secure this method is but after a few small tests i am happy to show others this approach.

The remove and move methods could give an error so you should check the php documentation for more information about that.

<b>Example Usage:<b>
```php
   <form method="post" action="upload.class.php" enctype="multipart/form-data">
   <input type="file" name="upload">
   <input type="submit" value="Upload">
   </form>

   <?php if ( isset( $_FILES[ 'upload' ] ) ): $upload = new Upload( 'upload' ); ?>
   <pre>
   Name:  <?php echo $upload -> getName() . "\n"; ?>
   Size:  <?php echo $upload -> getSize() . "\n"; ?>
   Type:  <?php echo $upload -> getMime() . "\n"; ?>
   Path:  <?php echo $upload -> getPath() . "\n"; ?>
   Error: <?php echo $upload -> getError(); ?>
   </pre>
   <?php endif; ?>
```

<b>Example 2:</b>

```php
  $upload = new Upload( 'upload' );
  
  if ( ! ( $e = $upload -> getError() ) )
  {
       echo 'Process rest of validation.';
  
       return;
  }
  
  echo $e;
```

<b>Callback Example: - (Requires callback.php)</b>

```
 $upload = new Upload( 'upload', function( $upload )
 {
    if ( $upload -> getSize() > 1024 )
    {
         $upload -> setError( 'Your file cannot exceed 1024kb.' );
         
         $upload -> remove();
         
         return;
    }
 
    $upload -> move( '/some/path/file.ext' );

 } );

 var_dump( $upload -> getError() ); 
```

In the above example the callback is only ever registered when the error in the files array equals 0 which indicates
no error occured, this allows you to do some soft checking and set an error which will be catched by the getError method.


<b>Additional Information</b>

For php to be able to return a error status for a file uploads your post_max_filesize needs to be bigger than your upload_max_filesize if this is the other way around then you will see some strange results like $_FILES being empty on post and in your error logs showing a similiar message to:

PHP Warning:  POST Content-Length of X bytes exceeds the limit of X bytes in Unknown on line 0
