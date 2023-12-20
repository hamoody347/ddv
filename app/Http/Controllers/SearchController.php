<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function Search(Request $request)
    {
        // return 'Success';
        // Validate that the SQL query is present in the request
        $request->validate([
            'db_query' => 'required',
        ]);

        // Get the SQL query from the request
        $sqlQuery = $request->input('db_query');

        // Check if the SQL query is a SELECT query
        if (stripos($sqlQuery, 'select') !== 0) {
            return response()->json([
                'success' => false,
                'error' => 'Only SELECT queries are allowed.',
            ], 400);
        }

        try {
            // Execute the SELECT query
            $results = DB::select($sqlQuery);

            return response()->json([
                'success' => true,
                'results' => $results,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
