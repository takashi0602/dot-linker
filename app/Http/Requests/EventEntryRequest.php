<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EventEntryRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'max:50',
            'field' => 'required',
            'opening_date' => 'date_format:yyyy-mm-dd|after:today',
            'start_at' => 'date_format:hh-mm',
            'end_at' => 'date_format:hh-mm|after:start_at',
            'capacity' => 'digits_between:1,99',
            'recruit_start_date' => 'date_format:yyyy-mm-dd|after:today',
            'recruit_end_date' => 'date_format:yyyy-mm-dd|after:recruit_start_date',
            'recruit_start_time' => 'date_format:hh:mm',
            'recruit_end_time' => 'date_format:hh:mm|after:recruit_start_time'
        ];
    }

    public function messages()
    {
        return[
        'name.max' => 'タイトルは50文字以下で入力してください。',
        'field.required' => '分野は必ず選択してください。',
        'opening_date.date_format' => '開催日を正しい形式で入力してください。',
        'opening_date.after' => '開催日は今日以降の日付を入力してください。',
        'start_at.date_format' => '開始時刻を正しい形式で入力してください。',
        'end_at.date_format' => '終了時刻を正しい形式で入力してください。',
        'end_at.after' => '終了時刻は開始時刻より後を入力してください。',
        'capacity.digits_between' => '定員は1~99の間で指定してください。',
        'recruit_start_date.date_format' => '募集開始日を正しい形式で入力してください。',
        'recruit_start_date.after' => '募集開始日は今日以降の日付で入力してください。',
        'recruit_end_date.date_format' => '募集終了日を正しい形式で入力してください。',
        'recruit_end_date.after' => '募集終了日は募集開始日以降の日付で入力してください。',
        'recruit_start_time.date_format' => '募集開始時刻を正しい形式で入力してください。',
        'recruit_end_time.date_format' => '募集終了時刻を正しい形式で入力してください。',
        'recruit_end_time.after' => '募集終了時刻は募集開始時刻より後を入力してください。'
        ];
    }
}
