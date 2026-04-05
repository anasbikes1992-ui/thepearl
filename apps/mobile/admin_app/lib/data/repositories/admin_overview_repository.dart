class AdminOverviewRepository {
  Future<List<Map<String, String>>> fetchOverviewCards() async {
    return const <Map<String, String>>[
      {'title': 'KYC Queue', 'subtitle': 'Pending provider/customer verifications'},
      {'title': 'Disputes', 'subtitle': 'Escrow dispute mediation queue'},
      {'title': 'Business Analytics', 'subtitle': 'GMV, churn, LTV, retention'},
      {'title': 'Webhook Monitor', 'subtitle': 'Stripe and PayHere delivery health'},
      {'title': 'Tenants & Expansion', 'subtitle': 'Franchise and market-readiness controls'},
    ];
  }
}
