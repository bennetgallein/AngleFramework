### Template Engine

Basic Documentation: The first line is the template language and the second is the PHP equivalent

###### echo Variable
```
{ :varname }
<?= $varname; ?>
```
###### set Variable
```
{ :varname = 1 }
<?php $varname = 1; ?>
```
###### foreach Loops
```
{ foreach :entry in :list}
<?php foreach ($list as $entry): ?>

{ foreach :entry in :list with :key }
<?php  foreach ($list as $key => $entry): ?>

{ endforeach }
<?php endforeach; ?>
```