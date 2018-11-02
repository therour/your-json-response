<?php

namespace Therour\YourJsonResponse;

use Illuminate\Http\Response;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Contracts\Pagination\Paginator;

class YJResponse implements Responsable
{
    /**
     * Response body.
     *
     * @var array
     */
    protected $data;

    protected $message;

    protected $code;

    protected $type;

    protected $meta_page;

    /**
     * Skeleton body response.
     *
     * @var array
     */
    protected $skeleton;

    /**
     * Create a response instance.
     *
     * @param mixed $data
     */
    public function __construct($data, $message, $code = 200, $skeleton = 'success')
    {
        $this->data = $data;
        $this->message = $message;
        $this->code = $code;
        $this->type = Response::$statusTexts[$code];

        $this->skeleton = config('yjresponse.skeleton.' . $skeleton);
    }

    /**
     * Set message attribute.
     *
     * @param string $message
     * @return Illuminate\Contracts\Support\Responsable
     */
    public function message($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Set code attribute.
     *
     * @param int $code
     * @return void
     */
    public function code($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        return response()->json( $this->buildFromSkeleton() , $this->code);
    }

    /**
     * Prepare array built by skeleton before encoded to json.
     *
     * @return array
     */
    protected function buildFromSkeleton()
    {
        if ($this->data instanceof Paginator) {
            $data = $this->data->toArray();

            $this->data = array_pull($data,'data');
            $this->meta_page = $data;
        }

        $json = $this->getValue($this->skeleton);
        
        if (is_null($this->meta_page)) {
            return array_except($json, ['meta_page']);
        }

        $pmeta = array_pull($json, 'meta_page');
        return array_merge($json, $pmeta ?? []);
    }

    /**
     * Get array result defined by skeleton.
     *
     * @param mixed $data
     * @return mixed
     */
    protected function getValue($data)
    {
        if (is_array($data)) {
            $result = [];
            foreach ($data as $key => $value) {
                $result[ is_integer($key) ? $value : $key ] = $this->getValue($value);
            }

            return $result;
        } else {

            return $this->{$data} ?? $data;
        }
    }
}