import '../models/dashboard_item.dart';

class CustomerHomeRepository {
  Future<List<DashboardItem>> fetchHomeCards() async {
    return const <DashboardItem>[
      DashboardItem(title: 'Concierge', subtitle: 'Plan a cross-vertical booking'),
      DashboardItem(title: 'My Escrow Orders', subtitle: 'Track holds and releases'),
      DashboardItem(title: 'PearlPoints', subtitle: 'View loyalty balance and rewards'),
      DashboardItem(title: 'Livestream Deals', subtitle: 'Join live shopping sessions and checkout instantly'),
      DashboardItem(title: 'Voice Booking', subtitle: 'Use Sinhala, Tamil, or English voice to search and book'),
      DashboardItem(title: 'Resale Marketplace', subtitle: 'Browse sustainable second-life premium inventory'),
      DashboardItem(title: 'Pearl Academy', subtitle: 'Learn travel, booking, and service quality best practices'),
    ];
  }
}
