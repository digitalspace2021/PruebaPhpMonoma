<?php

namespace App\Http\Controllers;

use App\Candidate;
use App\Http\Requests\Api\Candidate\StoreRequest;
use App\Http\Resources\CandidateRersource;
use Exception;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    /**
     * It creates a new candidate and returns a success response with the candidate resource
     *
     * @param StoreRequest request The request object.
     *
     * @return A new candidate resource
     */
    public function store(StoreRequest $request)
    {
        if($request->user()->cannot('create', Candidate::class)){
            return response()->error('You are not authorized to create a lead', 403);
        }
        try {
            $request->validated();
            $user=auth()->user();

            $candidate = Candidate::create([
                'name' => $request->name,
                'source' => $request->source,
                'user_id' => $request->user_id,
                'created_by' => $user->id,
            ]);

            return response()->success(
                new CandidateRersource($candidate),
                200
            );
        } catch (Exception $ex) {
            return response()->error($ex->getMessage(), $ex->getCode());
        }
    }

    /**
     * It returns a collection of candidates, either all of them or just the ones belonging to the
     * current user, depending on the user's role
     *
     * @return A collection of candidates
     */
    public function index()
    {
        try {
            $this->authorize('viewAny', Candidate::class);

            if (auth()->user()->role == 'agent') {
                $candidates = Candidate::where('user_id', auth()->user()->id)->get();
            } else {
                $candidates = Candidate::all();
            }

            return response()->success(
                CandidateRersource::collection($candidates),
                200
            );
        } catch (Exception $ex) {
            return response()->error($ex->getMessage(), 500);
        }
    }

    /**
     * If the candidate is not found, return a 404 error. If the user is not authorized to view the
     * candidate, return a 403 error. Otherwise, return the candidate
     *
     * @param id The id of the candidate you want to retrieve
     *
     * @return A candidate resource
     */
    public function show($id)
    {
        try {
            $candidate = Candidate::find($id);

            if (!$candidate) {
                return response()->error('Candidate not found', 404);
            }

            if(auth()->user()->cannot('view', $candidate)){
                return response()->error('You are not authorized to view this lead', 403);
            }

            return response()->success(
                new CandidateRersource($candidate),
                200
            );
        } catch (Exception $ex) {
            return response()->error($ex->getMessage(), 500);
        }
    }
}
