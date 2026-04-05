import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../../data/repositories/provider_dashboard_repository.dart';

final providerDashboardRepositoryProvider = Provider<ProviderDashboardRepository>((ref) {
  return ProviderDashboardRepository();
});

final providerDashboardCardsProvider = FutureProvider<List<Map<String, String>>>((ref) async {
  final repository = ref.watch(providerDashboardRepositoryProvider);
  return repository.fetchSummaryCards();
});
