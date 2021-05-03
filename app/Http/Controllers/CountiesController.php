<?php

namespace App\Http\Controllers;

use App\Models\County;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Validations\Validations;
use App\Repositories\CountyRepository;

/**
 * Class CountiesController
 *
 * @package App\Http\Controllers
 */
class CountiesController extends Controller
{
    use ApiResponser;

    private $countyRepository;

    public function __construct(CountyRepository $countyRepository)
    {
        $this->countyRepository = $countyRepository;
    }

    /**
     * Rules for validate fields.
     *
     * @var array
     */
    public static $rules = [
        'insert' => [
            'name'     => 'required|max:150',
            'state_id' => 'required|integer|greaterthanzero|verifylenght:10|exists:state,id'
        ],
        'update' => [
            'name'     => ['required', 'max:150'],
            'state_id' => ['required', 'integer', 'greaterthanzero', 'verifylenght:10','exists:state,id'],
            'nacceso'  => ['required', 'in:publico,privado,borrador']
        ]
    ];

    /**
     * Return all Counties.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $Counties = $this->countyRepository->index();

        return $this->successResponse($Counties,
            ($Counties->count() == 0) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK);
    }

    /**
     * Create an instance of County.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, static::$rules['insert']);

        $County = new County($request->all());
        $County = $this->countyRepository->store($County);

        return $this->successResponse($County, Response::HTTP_CREATED);
    }

    /**
     * Return an specific County.
     *
     * @param $countyId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($countyId)
    {
        $County = $this->countyRepository->show($countyId);

        return $this->successResponse($County);
    }

    /**
     * Update information County.
     *
     * @param Request $request
     * @param         $countyId
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $countyId)
    {
        $this->validate($request, Validations::removeRequiredValidationWhenFieldDoesNotExistInRequest(
            $request->keys(), static::$rules['update']));

        $County = $this->countyRepository->show($countyId);

        $County->fill($request->all());

        if ($County->isClean()) {
            return $this->errorResponse('At least one value must change',
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $County = $this->countyRepository->update($County);

        return $this->successResponse($County);
    }
}