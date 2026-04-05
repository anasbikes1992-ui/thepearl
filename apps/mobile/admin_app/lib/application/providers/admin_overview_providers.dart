import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../../data/repositories/admin_overview_repository.dart';

final adminOverviewRepositoryProvider = Provider<AdminOverviewRepository>((ref) {
  return AdminOverviewRepository();
});

final adminOverviewCardsProvider = FutureProvider<List<Map<String, String>>>((ref) async {
  final repository = ref.watch(adminOverviewRepositoryProvider);
  return repository.fetchOverviewCards();
});
