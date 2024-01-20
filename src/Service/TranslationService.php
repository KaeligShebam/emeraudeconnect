<?php
namespace App\Service;

use Symfony\Component\Yaml\Yaml;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class TranslationService
{
    private $translator;
    private $parameterBag;

    public function __construct(TranslatorInterface $translator, ParameterBagInterface $parameterBag)
    {
        $this->translator = $translator;
        $this->parameterBag = $parameterBag;
    }
    public function findTranslation(string $key): ?string
    {

        $yamlFilePath = $this->parameterBag->get('kernel.project_dir') . '/translations/validators.fr.yaml';

        $yamlContent = file_get_contents($yamlFilePath);
        $translations = Yaml::parse($yamlContent);

        $result = $this->searchKeyInArray($key, $translations);

        return $result;
    }

    public function searchKeyInArray(string $key, array $array): ?string
    {
        foreach ($array as $k => $v) {
            if ($k === $key) {
                return $v;
            } elseif (is_array($v)) {
                $result = $this->searchKeyInArray($key, $v);
                if ($result !== null) {
                    return $result;
                }
            }
        }

        return null;
    }
}
