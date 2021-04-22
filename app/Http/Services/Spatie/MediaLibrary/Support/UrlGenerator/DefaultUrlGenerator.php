<?php

namespace App\Http\Services\Spatie\MediaLibrary\Support\UrlGenerator;

use DateTimeInterface;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Spatie\MediaLibrary\Support\UrlGenerator\BaseUrlGenerator;

class DefaultUrlGenerator extends BaseUrlGenerator
{
    public function getUrl(): string
    {
        $url = $this->getDisk()->url($this->getPathRelativeToRoot());

        $url = $this->versionUrl($url);


        //enforces HTTPS
        $url = preg_replace("/^http:/i", "https:", $url);

        //The final URL is based on the URL provided in the .env file (APP_URL)
        //as subdomain are dynamic we need to replace the www with the real
        if (Route::is('frontend.*')){

            if (Session::has('fe_client.subdomain'))
            {

                $current_subdomain = Session::get('fe_client.subdomain');

            } else {
                dd(3);
                //breaks the current URL
                $parsedUrl = parse_url(url()->current());

                $host = explode('.', $parsedUrl['host']);

                $current_subdomain = $host[0];

            }

            $url = preg_replace("/www./i", $current_subdomain.".", $url);

        }

        return $url;
    }

    public function getTemporaryUrl(DateTimeInterface $expiration, array $options = []): string
    {
        return $this->getDisk()->temporaryUrl($this->getPathRelativeToRoot(), $expiration, $options);
    }

    public function getBaseMediaDirectoryUrl()
    {
        return $this->getDisk()->url('/');
    }

    public function getPath(): string
    {
        $adapter = $this->getDisk()->getAdapter();

        $cachedAdapter = '\League\Flysystem\Cached\CachedAdapter';

        if ($adapter instanceof $cachedAdapter) {
            $adapter = $adapter->getAdapter();
        }

        $pathPrefix = $adapter->getPathPrefix();

        return $pathPrefix.$this->getPathRelativeToRoot();
    }

    public function getResponsiveImagesDirectoryUrl(): string
    {
        $base = Str::finish($this->getBaseMediaDirectoryUrl(), '/');

        $path = $this->pathGenerator->getPathForResponsiveImages($this->media);

        return Str::finish(url($base.$path), '/');
    }
}
