<?php
	namespace App;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Http;

	class ApiHelper {
		
		public static function getUnits() {
			try {
				//code...
				$response = Http::get(env('API_URL').'/api/units');
	
				if ($response->successful()) {
					if ($response['data'] == null) {
						# code...
						$units = [];
					}else {
						foreach ($response['data'] as $unit) {
							$unit_id = $unit['id'] ?? null;
							$attributes = $unit['attributes'] ?? null;
							$unit_code = $attributes['code'] ?? null;
		
							if ($unit_id !== null && $unit_code !== null) {
								$units[$unit_id] = $unit_code;
							}
						}
					}
					// dd($units);
					return $units;
				}
			} catch (\Throwable $th) {
				//throw $th;
				return abort(500);
			}

			return null;
		}

		public function getProgrammes(Request $request) {
			// Retrieve the JSON data sent in the AJAX request and decode it
			$units = json_decode($request->input('units'));

			try {
				// Send a GET request to your API
				$response = Http::get(env('API_URL').'/api/programmes?populate=*');

				if ($response->successful()) {
					$programmes = [];

					// Loop through the API response data
					foreach ($response['data'] as $programme) {
						$unitId = $programme['attributes']['unit']['data']['id'] ?? null;

						// Check if the unitId is in the $units array
						if ($unitId !== null && in_array($unitId, $units)) {
							$programme_id = $programme['id'] ?? null;
							$attributes = $programme['attributes'] ?? null;
							$programme_code = $attributes['code'] ?? null;

							if ($programme_id !== null && $programme_code !== null) {
								$programmes[$programme_id] = $programme_code;
							}
						}
					}

					return $programmes;
				}
			} catch (\Throwable $th) {
				// Handle exceptions here if needed
				return abort(500);
			}

			return null;
		}

		public static function getStudents() {
			$response = Http::get(env('API_URL').'/api/students');

			if ($response->successful()) {
				return $response->json();
			}

			return null;
		}

	}
