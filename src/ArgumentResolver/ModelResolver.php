<?php


namespace App\ArgumentResolver;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * https://symfony.com/doc/current/controller/argument_value_resolver.html
 * Class ModelResolver
 * @package App\ArgumentResolver
 */
class ModelResolver implements ArgumentValueResolverInterface
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var string
     */
    private $namespace;

    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator, $namespace = 'App\\Dto\\')
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->namespace = $namespace;
    }

    /**
     * @inheritDoc
     */
    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        $model = $this->serializer->deserialize($request->getContent(), $argument->getType(), $request->getContentType());

        $violations = $this->validator->validate($model);
        if ($violations->count() > 0) {
            throw new ValidatorException($violations);
        }

        yield $model;
    }

    /**
     * @inheritDoc
     */
    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return strpos($argument->getType(), $this->namespace) === 0;
    }
}