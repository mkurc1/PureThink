<?php

namespace AppBundle\Controller\Admin;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ComponentHasElementAdminController extends CRUDController
{
    public function moveAction($id, $position)
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $id = $request->get($this->admin->getIdParameter());
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
        $message = $translator->trans('Position updated', [], 'AppBundle');
        $this->get('session')->getFlashBag()->set('sonata_flash_info', $message);

        return new RedirectResponse($this->admin->generateUrl('list', $this->admin->getFilterParameters()));
    }

}
