import 'package:dio/dio.dart';

import 'models.dart';

class PearlApiClient {
  PearlApiClient({required String baseUrl})
      : _dio = Dio(BaseOptions(baseUrl: baseUrl));

  final Dio _dio;

  Future<ConciergeResponse> conciergeChat({
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

    return ConciergeResponse.fromJson(response.data ?? <String, dynamic>{});
  }

  Future<List<dynamic>> listings() async {
    final response = await _dio.get<Map<String, dynamic>>('/listings');
    final payload = response.data ?? <String, dynamic>{};

    return payload['data']?['data'] as List<dynamic>? ?? <dynamic>[];
  }

  Future<Map<String, dynamic>> loyaltyProfile() async {
    final response = await _dio.get<Map<String, dynamic>>('/loyalty/me');
    return response.data ?? <String, dynamic>{};
  }
}
