import 'package:dio/dio.dart';

class PearlApiClient {
  PearlApiClient({required String baseUrl})
      : _dio = Dio(BaseOptions(baseUrl: baseUrl));

  final Dio _dio;

  Future<Map<String, dynamic>> conciergeChat({
    required String message,
    String locale = 'en',
  }) async {
    final response = await _dio.post<Map<String, dynamic>>(
      '/concierge/chat',
      data: {
        'message': message,
        'locale': locale,
      },
    );

    return response.data ?? <String, dynamic>{};
  }
}
