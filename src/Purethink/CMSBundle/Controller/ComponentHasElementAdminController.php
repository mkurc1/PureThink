<?php

namespace Purethink\CMSBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ComponentHasElementAdminController extends CRUDController
{
    public function moveAction($id, $position)
    {
        $id = $this->get('request')->get($this->admin->getIdParameter());
        $object = $this->admin->getObject($id);

        $position_service = $this->get('pix_sortable_behavior.position');
        $lastPosition = $object->getComponent()->getElements()->count() - 1;
        $position = $position_service->getPosition($object, $position, $lastPosition);

        $object->setPosition($position);
        $this->admin->update($object);

        if ($this->isXmlHttpRequest()) {
            return $this->renderJson([
                'result'   => 'ok',
                'objectId' => $this->admin->getNormalizedIdentifier($object)
            ]);
        }
        $translator = $this->get('translator');
        $this->get('session')->getFlashBag()->set('sonata_flash_info', $translator->trans('Position updated'));

        return new RedirectResponse($this->admin->generateUrl('list', $this->admin->getFilterParameters()));
    }

}
