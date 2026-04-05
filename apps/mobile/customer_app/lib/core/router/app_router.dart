import 'package:flutter/material.dart';
import 'package:go_router/go_router.dart';

import '../../features/home/presentation/customer_home_screen.dart';

GoRouter customerRouter() {
  return GoRouter(
    routes: <RouteBase>[
      GoRoute(
        path: '/',
        builder: (BuildContext context, GoRouterState state) => const CustomerHomeScreen(),
      ),
    ],
  );
}
