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
  
  if ( ! ( $e -> $upload -> getError() ) )
  {
       echo 'Process rest of validation.';
  
       return;
  }
  
  echo 'An error was encountered.';
```
