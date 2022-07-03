<?php

namespace Brezgalov\RightsManager;

use Brezgalov\RightsManager\Services\ConstantsStorageService\IConstantsStorageService;

interface IGetRightsManagerSettings
{
    /**
     * @return IConstantsStorageService
     */
    public function getConstantsStorageService();

    /**
     * @return bool
     */
    public function useConstantsStorageService();
}