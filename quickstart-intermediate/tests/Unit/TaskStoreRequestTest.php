<?php

use App\Http\Requests\TaskStoreRequest;

class TaskStoreRequestTest extends TestCase
{
    /**
     * タスク作成時のバリデーションテスト
     *
     * @param string タスク名
     * @param boolean バリデーションOKかどうか
     * @dataProvider testTaskStoreValidationDataProvider
     */
    public function testTaskStoreValidation($data, $expected)
    {
        $dataList = ['name' => $data];

        $request = new TaskStoreRequest();
        $rules = $request->rules();
        $validator = Validator::make($dataList, $rules);

        $result = $validator->passes();
        $this->assertEquals($expected, $result);
    }

    /**
     * @return array
     */
    public function testTaskStoreValidationDataProvider()
    {
        return [
            '0文字のタスクはバリデーションエラーを返すこと' => ['', false],
            '1文字のタスクは必ず通ること' => ['ほ', true],
            '255文字のタスクは必ず通ること' => [str_repeat('ほ', 255), true],
            '256文字のタスクはバリデーションエラーを必ず通ること' => [str_repeat('ほ', 256), false],
        ];
    }
}