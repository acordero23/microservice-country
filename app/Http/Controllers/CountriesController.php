<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Validations\Validations;
use App\Repositories\CountryRepository;

/**
 * Class CountriesController
 *
 * @package App\Http\Controllers
 */
class CountriesController extends Controller
{
    use ApiResponser;

    private $countryRepository;

    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    /**
     * Rules for validate fields.
     *
     * @var array
     */
    public static $rules = [
        'insert' => [
            'name'         => 'required|max:150',
            'abbreviation' => 'required|max:2'
        ],
        'update' => [
            'name'         => ['required', 'max:150'],
            'abbreviation' => ['required', 'max:2'],
            'nacceso'      => ['required', 'in:publico,privado,borrador']
        ]
    ];

    /**
     * Return all Countries.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $Countries = $this->countryRepository->index();

        return $this->successResponse($Countries,
            ($Countries->count() == 0) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK);
    }

    /**
     * Create an instance of Country.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, static::$rules['insert']);

        $Country = new Country($request->all());
        $Country = $this->countryRepository->store($Country);

        return $this->successResponse($Country, Response::HTTP_CREATED);
    }

    /**
     * Return an specific Country.
     *
     * @param $countryId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($countryId)
    {
        $Country = $this->countryRepository->show($countryId);

        return $this->successResponse($Country);
    }

    /**
     * Update information Country.
     *
     * @param Request $request
     * @param         $countryId
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $countryId)
    {
        $this->validate($request, Validations::removeRequiredValidationWhenFieldDoesNotExistInRequest(
            $request->keys(), static::$rules['update']));

        $Country = $this->countryRepository->show($countryId);

        $Country->fill($request->all());

        if ($Country->isClean()) {
            return $this->errorResponse('At least one value must change',
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $Country = $this->countryRepository->update($Country);

        return $this->successResponse($Country);
    }
}