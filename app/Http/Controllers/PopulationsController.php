<?php

namespace App\Http\Controllers;

use App\Models\Population;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Validations\Validations;
use App\Repositories\PopulationRepository;

/**
 * Class PopulationsController
 *
 * @package App\Http\Controllers
 */
class PopulationsController extends Controller
{
    use ApiResponser;

    private $populationRepository;

    public function __construct(PopulationRepository $populationRepository)
    {
        $this->populationRepository = $populationRepository;
    }

    /**
     * Rules for validate fields.
     *
     * @var array
     */
    public static $rules = [
        'insert' => [
            'name'      => 'required|max:150',
            'zip_code'  => 'required|numeric|greaterthanzero|verifylenght:10',
            'county_id' => 'required|integer|greaterthanzero|verifylenght:10|exists:county,id'
        ],
        'update' => [
            'name'      => ['required', 'max:150'],
            'zip_code'  => ['required', 'numeric', 'greaterthanzero', 'verifylenght:10'],
            'county_id' => ['required', 'integer', 'greaterthanzero', 'verifylenght:10', 'exists:county,id'],
            'nacceso'   => ['required', 'in:publico,privado,borrador']
        ],
    ];

    /**
     * Return all Populations.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $Populations = $this->populationRepository->index();

        return $this->successResponse($Populations,
            ($Populations->count() == 0) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK);
    }

    /**
     * Create an instance of Population.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $rules = static::$rules['insert'];
        $this->validate($request, $rules);

        $rules['zip_code'] = $rules['zip_code'] .
            "|existzipcode:population,zip_code,{$data['zip_code']},{$data['county_id']}";

        $this->validate($request, $rules);

        $Population = new Population($data);
        $Population = $this->populationRepository->store($Population);

        return $this->successResponse($Population, Response::HTTP_CREATED);
    }

    /**
     * Return an specific Population.
     *
     * @param $populationId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($populationId)
    {
        $Population = $this->populationRepository->show($populationId);

        return $this->successResponse($Population);
    }

    /**
     * Update information Population.
     *
     * @param Request $request
     * @param         $populationId
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $populationId)
    {
        $data = $request->all();

        $rules = Validations::removeRequiredValidationWhenFieldDoesNotExistInRequest(
            $request->keys(), static::$rules['update']);
        $this->validate($request, $rules);

        if (array_key_exists('county_id', $data) || array_key_exists('zip_code', $data)) {
            $rules = [
                'zip_code'  => 'existfieldintorequest:' . array_key_exists('county_id', $data),
                'county_id' => 'existfieldintorequest:' . array_key_exists('zip_code', $data),
            ];
            $this->validate($request, $rules);
        }

        $Population = $this->populationRepository->show($populationId);

        $Population->fill($data);

        if ($Population->isClean()) {
            return $this->errorResponse('At least one value must change',
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (array_key_exists('county_id', $data) || array_key_exists('zip_code', $data)) {
            $rules = ['zip_code' => "existzipcode:population,zip_code,{$data['zip_code']},{$data['county_id']}"];
            $this->validate($request, $rules);
        }

        $Population = $this->populationRepository->update($Population);

        return $this->successResponse($Population);
    }

    /**
     * Find information of the zip code.
     *
     * @param $zipCode
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function find($zipCode)
    {
        $Information = $this->populationRepository->find($zipCode);

        return $this->successResponse($Information,
            ($Information->count() == 0) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK);
    }
}