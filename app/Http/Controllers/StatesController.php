<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Validations\Validations;
use App\Repositories\StateRepository;

/**
 * Class StatesController
 *
 * @package App\Http\Controllers
 */
class StatesController extends Controller
{
    use ApiResponser;

    private $stateRepository;

    public function __construct(StateRepository $stateRepository)
    {
        $this->stateRepository = $stateRepository;
    }

    /**
     * Rules for validate fields.
     *
     * @var array
     */
    public static $rules = [
        'insert' => [
            'name'       => 'required|max:150',
            'country_id' => 'required|integer|greaterthanzero|verifylenght:10|exists:country,id'
        ],
        'update' => [
            'name'       => ['required', 'max:150'],
            'country_id' => ['required', 'integer', 'greaterthanzero', 'verifylenght:10','exists:country,id'],
            'nacceso'    => ['required', 'in:publico,privado,borrador']
        ]
    ];

    /**
     * Return all States.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $States = $this->stateRepository->index();

        return $this->successResponse($States,
            ($States->count() == 0) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK);
    }

    /**
     * Create an instance of State.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, static::$rules['insert']);

        $State = new State($request->all());
        $State = $this->stateRepository->store($State);

        return $this->successResponse($State, Response::HTTP_CREATED);
    }

    /**
     * Return an specific State.
     *
     * @param $stateId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($stateId)
    {
        $State = $this->stateRepository->show($stateId);

        return $this->successResponse($State);
    }

    /**
     * Update information State.
     *
     * @param Request $request
     * @param         $stateId
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $stateId)
    {
        $this->validate($request, Validations::removeRequiredValidationWhenFieldDoesNotExistInRequest(
            $request->keys(), static::$rules['update']));

        $State = $this->stateRepository->show($stateId);

        $State->fill($request->all());

        if ($State->isClean()) {
            return $this->errorResponse('At least one value must change',
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $State = $this->stateRepository->update($State);

        return $this->successResponse($State);
    }
}