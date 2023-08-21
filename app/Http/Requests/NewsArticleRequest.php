<?php

    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class NewsArticleRequest extends FormRequest
    {
        /**
         * Determine if the user is authorized to make this request.
         *
         * @return bool
         */
        public function authorize()
        {
            // only allow updates if the user is logged in
            return backpack_auth()->check() && [backpack_user()->can(config('permission.profile')) || backpack_user()->can('permission.demo')];
        }

        /**
         * Get the validation rules that apply to the request.
         *
         * @return array
         */
        public function rules()
        {
            return [
                // 'title' => 'required|min:2',
                // 'slug' => 'required|unique:news_articles,slug,' . \Request::get('id'),
                // 'content' => 'nullable|min:2|max:67295',
                // 'short_desc' => '|required_if:short_sms_switch,1|max:200',
                // 'recipient' => 'required',
            ];
        }

        /**
         * Get the validation attributes that apply to the request.
         *
         * @return array
         */
        public function attributes()
        {
            return [
                //
            ];
        }

        /**
         * Get the validation messages that apply to the request.
         *
         * @return array
         */
        public function messages()
        {
            return [
                //
            ];
        }
    }
