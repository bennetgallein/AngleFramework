### Template Engine

Basic Documentation: The first line is the template language and the second is the PHP equivalent

#### Installation
Please use this Engine only with composer:
```json
"repositories": [{
  "type": "composer",
  "url": "https://packages.streamtitties.fun"
}],
```
And 
```
"require": {
    "bennetgallein/angle-framework": "dev-master"
},
```
### TODO:
- implement native Logging to a file with different important steps.

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

