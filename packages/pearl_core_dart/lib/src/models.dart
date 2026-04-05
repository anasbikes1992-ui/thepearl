class ConciergeResponse {
  const ConciergeResponse({
    required this.reply,
    this.provider,
  });

  final String reply;
  final String? provider;

  factory ConciergeResponse.fromJson(Map<String, dynamic> json) {
    return ConciergeResponse(
      reply: json['reply'] as String? ?? '',
      provider: json['provider'] as String?,
    );
  }
}
