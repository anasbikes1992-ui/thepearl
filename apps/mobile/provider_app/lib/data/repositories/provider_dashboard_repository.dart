class ProviderDashboardRepository {
  Future<List<Map<String, String>>> fetchSummaryCards() async {
    return const <Map<String, String>>[
      {'title': 'Listings Moderation', 'subtitle': 'Draft to publish workflow'},
      {'title': 'Bookings Queue', 'subtitle': 'Upcoming and active orders'},
      {'title': 'Payouts', 'subtitle': 'Escrow release settlements'},
      {'title': 'Livestream Studio', 'subtitle': 'Schedule and manage live selling events'},
      {'title': 'Demand Insights', 'subtitle': 'Predictive signals across cities and verticals'},
    ];
  }
}
