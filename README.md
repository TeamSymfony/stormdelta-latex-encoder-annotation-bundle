StormDelta LatexEncoder AnnotationBundle
========================================
This bundle is still under development!

Use annotations to safely encode values to LaTeX.
Installation
------------
```
composer require stormdelta/latex-encoder-annotation-bundle
```
Configuration
-------------
Configure Bundle in `app/AppKernel.php`
```
//app/AppKernel.php

use ...

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            ...
            new StormDelta\LatexEncoder\AnnotationBundle\StormDeltaLatexEncoderAnnotationBundle(),
            ...
        );
        ...
}
```

Usage
-----
Use annotations in the entity
```
//src/AppBundle/Entity/LatexEntity.php

namespace AppBundle\Entity\LatexEntity;

use StormDelta\LatexEncoder\AnnotationBundle\Annotation\LatexEncoderAnnotation as LatexEncode;

class LatexEntity
{
    /**
     * @LatexEncode
     */
    $variable;
}
```

Encode in the controller
```
//src/AppBundle/Controller/DefaultController.php

namespace AppBundle\Controller;

use ...

class DefaultController extends Controller
{
    ...
    public function indexAction(...)
    {
        $entity = new LatexEntity();
        ...
        $entity = $this->get('stormdelta.latexencoder.driver')->encode($entity);
        ...
        return array('entity' => $entity);
    }
}
```
