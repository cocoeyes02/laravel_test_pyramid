<?php

use App\Http\Controllers\Auth\AuthController;

class RegisterValidationTest extends TestCase
{
    /**
     * タスク作成時のバリデーションテスト
     *
     * @param string タスク名
     * @param boolean バリデーションOKかどうか
     * @dataProvider testTaskStoreValidationDataProvider
     */
    public function testUserRegisterValidation($data, $expected)
    {
        $validator = $this->doMethod('validator', $data);
        $result = !$validator->fails();
        $this->assertSame($expected, $result);
    }

    /**
     * @return array
     */
    public function testTaskStoreValidationDataProvider()
    {
        return [
            '何も入力しなければエラーになること' => [
                [
                    'name' => '',
                    'email' => '',
                    'password' => '',
                    'password_confirmation' => '',
                ],
                false
            ],
            'ユーザ名入力しなければエラーになること' => [
                [
                    'name' => '',
                    'email' => 'test@example.com',
                    'password' => 'Testtest1',
                    'password_confirmation' => 'Testtest1',
                ],
                false
            ],
            '256文字のユーザ名を入力するとエラーになること' => [
                [
                    'name' => str_repeat('ほ', 256),
                    'email' => 'test@example.com',
                    'password' => 'Testtest1',
                    'password_confirmation' => 'Testtest1',
                ],
                false
            ],
            'メールアドレスを入力しなければエラーになること' => [
                [
                    'name' => 'UnitTester',
                    'email' => '',
                    'password' => 'Testtest1',
                    'password_confirmation' => 'Testtest1',
                ],
                false
            ],
            'xxx@yyy.zzzのフォーマットになっていないメールを入力するとエラーになること' => [
                [
                    'name' => 'UnitTester',
                    'email' => 'test@example',
                    'password' => 'Testtest1',
                    'password_confirmation' => 'Testtest1',
                ],
                false
            ],
            '256文字のユーザ名を入力するとエラーになること' => [
                [
                    'name' => 'UnitTester',
                    'email' => str_repeat('ほ', 245) . '@example.com',
                    'password' => 'Testtest1',
                    'password_confirmation' => 'Testtest1',
                ],
                false
            ],
            'パスワードを入力しなければエラーになること' => [
                [
                    'name' => 'UnitTester',
                    'email' => 'test@example.com',
                    'password' => '',
                    'password_confirmation' => '',
                ],
                false
            ],
            'パスワードが5文字以下だとエラーになること' => [
                [
                    'name' => 'UnitTester',
                    'email' => 'test@example.com',
                    'password' => 'Test1',
                    'password_confirmation' => 'Test1',
                ],
                false
            ],
            'パスワードと確認用パスワードで相違があるとエラーになること' => [
                [
                    'name' => 'UnitTester',
                    'email' => 'test@example.com',
                    'password' => 'Test1',
                    'password_confirmation' => 'Test',
                ],
                false
            ],
            'ユーザ名、メールアドレス、パスワードを正しく入力するとエラーにならないこと' => [
                [
                    'name' => 'unittester',
                    'email' => 'test@example.com',
                    'password' => 'Testtest1',
                    'password_confirmation' => 'Testtest1',
                ],
                true
            ],
        ];
    }

    /**
     * 参考：https://qiita.com/ponsuke0531/items/6dc6fc34fff1e9b37901
     * privateメソッドを実行する.
     * @param string $methodName privateメソッドの名前
     * @param array $param privateメソッドに渡す引数
     * @return mixed 実行結果
     * @throws \ReflectionException 引数のクラスがない場合に発生.
     */
    private function doMethod($methodName, array $param)
    {
        // テスト対象のクラスをnewする.
        $controller = new AuthController();
        // ReflectionClassをテスト対象のクラスをもとに作る.
        $reflection = new \ReflectionClass($controller);
        // メソッドを取得する.
        $method = $reflection->getMethod($methodName);
        // アクセス許可をする.
        $method->setAccessible(true);
        // メソッドを実行して返却値をそのまま返す.
        return $method->invokeArgs($controller, [$param]);
    }
}