<?php

namespace Container8D8K8YR;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getCache_SystemClearerService extends App_KernelDevDebugContainer
{
    /**
     * Gets the public 'cache.system_clearer' shared service.
     *
     * @return \Symfony\Component\HttpKernel\CacheClearer\Psr6CacheClearer
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/http-kernel/CacheClearer/CacheClearerInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/http-kernel/CacheClearer/Psr6CacheClearer.php';

        return $container->services['cache.system_clearer'] = new \Symfony\Component\HttpKernel\CacheClearer\Psr6CacheClearer(['cache.system' => ($container->services['cache.system'] ?? self::getCache_SystemService($container)), 'cache.validator' => ($container->privates['cache.validator'] ?? self::getCache_ValidatorService($container)), 'cache.serializer' => ($container->privates['cache.serializer'] ?? self::getCache_SerializerService($container)), 'cache.property_info' => ($container->privates['cache.property_info'] ?? self::getCache_PropertyInfoService($container)), 'cache.asset_mapper' => ($container->privates['cache.asset_mapper'] ?? self::getCache_AssetMapperService($container)), 'cache.validator_expression_language' => ($container->services['cache.validator_expression_language'] ?? self::getCache_ValidatorExpressionLanguageService($container)), 'cache.security_expression_language' => ($container->privates['cache.security_expression_language'] ?? self::getCache_SecurityExpressionLanguageService($container)), 'cache.security_is_granted_attribute_expression_language' => ($container->services['cache.security_is_granted_attribute_expression_language'] ?? self::getCache_SecurityIsGrantedAttributeExpressionLanguageService($container)), 'cache.security_is_csrf_token_valid_attribute_expression_language' => ($container->services['cache.security_is_csrf_token_valid_attribute_expression_language'] ?? self::getCache_SecurityIsCsrfTokenValidAttributeExpressionLanguageService($container))]);
    }
}
